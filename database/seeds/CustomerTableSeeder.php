<?php

use Illuminate\Database\Seeder;

use App\Models\Customer\Order\Order;
use App\Models\Customer\Subscription\Subscription;

use \App\Models\Customer\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedCustomers();
        $this->seedCustomers("non_active");
        $this->seedCustomers("active");

        $this->seedCustomers(null, "unpaid");
        $this->seedCustomers(null, "paid");

        $this->seedCustomers("non_active", "unpaid");
        $this->seedCustomers("active", "unpaid");
        $this->seedCustomers("non_active", "paid");
        $this->seedCustomers("active", "paid");

        $this->seedCustomers("non_active", "unpaid", 5, 1);
        $this->seedCustomers("active", "unpaid", 5, 1);
        $this->seedCustomers("non_active", "paid", 5, 1);
        $this->seedCustomers("active", "paid", 5, 1);
    }

    protected function seedCustomers($subscriptionStatus = null, $ordersStatus = null, $customersCount = 5, $ordersCount = 5) {
        $this->createCustomers($customersCount, function($customer) use ($subscriptionStatus, $ordersStatus, $ordersCount) {
            $subscription = null;

            if ($subscriptionStatus != null) {
                $subscription = $this->createSubscription($subscriptionStatus, $customer);
            }

            if ($ordersStatus != null) {
                for ($i = 0; $i <= $ordersCount; $i++) {
                    $this->createOrder(Order::STATUS_CREATED, $customer, $subscription);
                    $this->createOrder(Order::STATUS_FAILED, $customer, $subscription);

                    if ($ordersStatus == "paid") {
                        $this->createOrder(Order::STATUS_PAID, $customer, $subscription);
                    }
                }
            }
        });
    }

    protected function createSubscription($active, Customer $customer) {
        $subscription = factory(Subscription::class, $active)->make();
        $subscription->customer()
            ->associate($customer)
            ->save();

        return $subscription;
    }

    protected function createOrder($status, Customer $customer, $subscription = null) {
        $order = factory(Order::class, $status)->make();
        $order->customer()->associate($customer);

        if ($subscription) {
            $order->subscription()->associate($subscription);
        }

        $order->save();

        return $order;
    }

    protected function createCustomers($count, $callback = null) {
        $customers = factory(App\Models\Customer\Customer::class, $count)
            ->create();

        if ($callback) {
            $customers->each($callback);
        }

        return $customers;
    }
}
