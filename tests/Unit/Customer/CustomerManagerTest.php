<?php

namespace tests\Unit\Customer;


use App\Models\Customer\CustomerManager;
use App\Models\Customer\Order\Order;
use Tests\CustomerTestCase;

class CustomerManagerTest extends CustomerTestCase
{
    public function test_get_collection_with_paid_order() {
        $manager = new CustomerManager();
        $customers = $manager->getCollectionWithPaidOrder();
        $this->assertNotCount(0, $customers);


        foreach ($customers as $customer) {
            $orders = $customer->orders()->where("status", Order::STATUS_PAID)->get();

            $this->assertNotCount(0, $orders);
            $this->assertNotCount(1, $orders);
        }
    }

    public function test_get_collection_with_active_subscription_and_paid_order() {
        $manager = new CustomerManager();
        $customers = $manager->getCollectionWithActiveSubscriptionAndPaidOrder();

        $this->assertNotCount(0, $customers);

        foreach ($customers as $customer) {
            $orders = $customer->orders()->where("status", Order::STATUS_PAID)->get();

            $this->assertNotCount(0, $orders);
            $this->assertNotCount(1, $orders);

            $subscription = $customer->getSubscription();
            $this->assertTrue($subscription->getActive());
        }
    }
}