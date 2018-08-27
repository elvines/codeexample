<?php

namespace tests\Feature;


use App\Models\Customer\Subscription\Subscription;
use Tests\CustomerTestCase;

class SubscriptionTest extends CustomerTestCase
{
    public function test_update_nextorder_date() {
        $oldSubscription = Subscription::first();

        $this->assertInstanceOf('App\Models\Customer\Subscription\Subscription', $oldSubscription);

        $data = array(
            'subscription' => [
                'id' => $oldSubscription->getId(),
            ]
        );

        $response = $this->call('POST','api/customer/subscription/update/nextOrderDate', $data);

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("subscription", $responseContent['data']);
        $this->assertArrayHasKey("id", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("active", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("customer_id", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("start_date", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("day_iteration", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("active", $responseContent['data']['subscription']);

        $this->assertNotEquals($oldSubscription->getNextorderDate(), $responseContent['data']['subscription']['nextorder_date']);

        $nextOrderDate = new \DateTime($oldSubscription->getNextorderDate());
        $dateInterval = new \DateInterval("P". $oldSubscription->getDayiteration() . "D");
        $nextOrderDate->add( $dateInterval );

        $this->assertEquals($responseContent['data']['subscription']['nextorder_date'], $nextOrderDate->format("Y-m-d"));
    }

    public function test_set_day_iteration() {
        /**
         * This conflicts with Subscription/ManagerTest->testSetDayIteration, so we need an offset
         */
        $oldSubscription = Subscription::offset(1)->first();

        $this->assertInstanceOf('App\Models\Customer\Subscription\Subscription', $oldSubscription);

        $data = array(
            'subscription' => [
                'id' => $oldSubscription->getId(),
                'day_iteration' => 155
            ]
        );

        $response = $this->call('POST','api/customer/subscription/update/dayIteration', $data);

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("subscription", $responseContent['data']);
        $this->assertArrayHasKey("id", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("active", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("customer_id", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("start_date", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("day_iteration", $responseContent['data']['subscription']);
        $this->assertArrayHasKey("active", $responseContent['data']['subscription']);

        $this->assertEquals($responseContent['data']['subscription']['day_iteration'], $data['subscription']['day_iteration']);
    }

    public function test_set_day_iteration_to_zero() {
        $oldSubscription = Subscription::first();

        $this->assertInstanceOf('App\Models\Customer\Subscription\Subscription', $oldSubscription);

        $data = array(
            'subscription' => [
                'id' => $oldSubscription->getId(),
                'day_iteration' => 0
            ]
        );

        $response = $this->call('POST','api/customer/subscription/update/dayIteration', $data);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_set_day_iteration_to_zero_without_subscription() {
        $data = array(
            'subscription' => [
                'id' => 0,
                'day_iteration' => 0
            ]
        );

        $response = $this->call('POST','api/customer/subscription/update/dayIteration', $data);

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function test_set_day_iteration_subscription_id_overflow() {
        $data = array(
            'subscription' => [
                'id' => 2000,
                'day_iteration' => 0
            ]
        );

        $response = $this->call('POST','api/customer/subscription/update/dayIteration', $data);

        $this->assertEquals(400, $response->getStatusCode());
    }
}