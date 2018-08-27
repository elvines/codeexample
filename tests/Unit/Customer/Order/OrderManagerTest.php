<?php

namespace tests\Unit\Customer\Order;

use App\Models\Customer\Customer;
use App\Models\Customer\Order\Order;
use App\Models\Customer\Order\OrderManager;
use Tests\CustomerTestCase;

class OrderManagerTest extends CustomerTestCase
{
    public function test_store_based_on_subscription_date() {
        $customer = Customer::has("subscription")->first();
        $this->assertNotNull($customer);

        $orderData = [
            'customer_id' => $customer->getId(),
            'total' => 999
        ];

        $manager = new OrderManager();

        $order = $manager->storeBasedOnSubscriptionDate($orderData);

        $this->assertInstanceOf('App\Models\Customer\Order\Order', $order);

        $orderCheck = Order::find($order->getId());
        $this->assertInstanceOf('App\Models\Customer\Order\Order', $orderCheck);
        $this->assertEquals($customer->getId(), $orderCheck->getCustomerId());
        $this->assertEquals(999, $orderCheck->getTotal());

        $this->assertEquals($order->getSubscription()->getNextorderDate(), $order->getPaidDate());
        $this->assertEquals($order->getStatus(), Order::STATUS_PAID);
    }

    public function test_store_based_on_subscription_date_invalid_total() {
        $customer = Customer::doesntHave("subscription")->first();
        $this->assertNotNull($customer);

        $orderData = [
            'customer_id' => $customer->getId(),
            'total' => 999
        ];

        $order = null;
        $manager = new OrderManager();

        try {
            $order = $manager->storeBasedOnSubscriptionDate($orderData);
        } catch (\ErrorException $e) {

        }

        $this->assertNull($order);
    }

    public function test_get_customer_last_paid_order() {
        $customer = Customer::whereHas('orders', function($q) {
            $q->where("order.status", "=", Order::STATUS_PAID);
        })->first();

        $this->assertInstanceOf('App\Models\Customer\Customer', $customer);

        $orderCheck = $customer->orders()->where("status", "=", Order::STATUS_PAID)->orderBy("paid_date", "desc")->first();

        $this->assertInstanceOf('App\Models\Customer\Order\Order', $orderCheck);

        $manager = new OrderManager();
        $order = $manager->getCustomerLastPaidOrder($customer->getId());
        $this->assertInstanceOf('App\Models\Customer\Order\Order', $order);

        $this->assertEquals($order->getPaidDate(), $orderCheck->getPaidDate());
    }

    public function test_get_customer_last_paid_order_on_customer_without_paid_order() {
        $customer = Customer::whereHas('orders', function($q) {
            $q->where("order.status", "!=", Order::STATUS_PAID);
        })->first();

        $this->assertInstanceOf('App\Models\Customer\Customer', $customer);

        $manager = new OrderManager();
        $order = $manager->getCustomerLastPaidOrder($customer->getId());

        $this->assertNull($order);
    }
}