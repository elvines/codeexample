<?php

namespace tests\Feature;


use App\Models\Customer\Customer;
use App\Models\Customer\Order\Order;
use Tests\CustomerTestCase;

class OrderTest extends CustomerTestCase
{
    public function test_order_store() {
        $customer = Customer::has("subscription")->first();
        $this->assertNotNull($customer);

        $data = array(
            'order' => [
                'customer_id' => $customer->getId(),
                'total' => 100
            ]
        );

        $response = $this->call('POST','/api/customer/order/store/basedOnSubscription', $data);

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("order", $responseContent['data']);
        $this->assertArrayHasKey("total", $responseContent['data']['order']);
        $this->assertEquals(100, $responseContent['data']['order']['total']);
    }

    public function test_order_store_customer_has_no_subscription() {
        $customer = Customer::doesntHave("subscription")->first();
        $this->assertNotNull($customer);

        $data = array(
            'order' => [
                'customer_id' => $customer->getId(),
                'total' => 100
            ]
        );

        $response = $this->call('POST','/api/customer/order/store/basedOnSubscription', $data);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_order_store_with_total_equals_zero() {
        $customer = Customer::has("subscription")->first();
        $this->assertNotNull($customer);

        $data = array(
            'order' => [
                'customer_id' => $customer->getId(),
                'total' => 0
            ]
        );

        $response = $this->call('POST','/api/customer/order/store/basedOnSubscription', $data);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_get_last_paid_order() {
        $customer = Customer::whereHas('orders', function($q) {
            $q->where("order.status", "=", Order::STATUS_PAID);
        })->first();

        $this->assertInstanceOf('App\Models\Customer\Customer', $customer);

        $orderCheck = $customer->orders()->where("status", "=", Order::STATUS_PAID)->orderBy("paid_date", "desc")->first();

        $this->assertInstanceOf('App\Models\Customer\Order\Order', $orderCheck);

        $data = array(
            'order' => [
                'customer_id' => $customer->getId(),
            ]
        );

        $response = $this->call('GET','api/customer/'. $customer->getId() .'/order/get/lastPaidOrder', $data);

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("order", $responseContent['data']);
        $this->assertArrayHasKey("id", $responseContent['data']['order']);
        $this->assertArrayHasKey("status", $responseContent['data']['order']);
        $this->assertArrayHasKey("customer_id", $responseContent['data']['order']);
        $this->assertArrayHasKey("subscription_id", $responseContent['data']['order']);
        $this->assertArrayHasKey("total", $responseContent['data']['order']);
        $this->assertArrayHasKey("paid_date", $responseContent['data']['order']);

        $this->assertEquals($orderCheck->getPaidDate(), $responseContent['data']['order']['paid_date']);
    }

    public function test_get_last_paid_order_user_has_no_orders() {
        $customer = Customer::doesntHave('orders')->first();

        $this->assertInstanceOf('App\Models\Customer\Customer', $customer);

        $response = $this->call('GET','api/customer/'. $customer->getId() .'/order/get/lastPaidOrder');

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("order", $responseContent['data']);
        $this->assertNull($responseContent['data']['order']);
    }

    public function test_get_last_paid_order_customer_id_equals_zero() {
        $response = $this->call('GET','api/customer/0/order/get/lastPaidOrder');

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_get_last_paid_order_customer_id_overflow() {
        $response = $this->call('GET','api/customer/2000/order/get/lastPaidOrder');

        $this->assertEquals(400, $response->getStatusCode());
    }
}