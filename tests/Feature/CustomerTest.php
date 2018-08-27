<?php

namespace tests\Feature;


use Tests\CustomerTestCase;

class CustomerTest extends CustomerTestCase
{
    public function test_get_collection_with_paid_order() {
        $response = $this->call('GET','api/customer/collection/withPaidOrder');

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("customers", $responseContent['data']);

        $customers = $responseContent['data']['customers'];

        $this->assertNotCount(0, $customers);
    }

    public function test_get_collection_with_active_subscription_and_paid_order() {
        $response = $this->call('GET','api/customer/collection/withActiveSubscriptionAndPaidOrder');

        $this->assertEquals(200, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseContent);
        $this->assertArrayHasKey("customers", $responseContent['data']);

        $customers = $responseContent['data']['customers'];

        $this->assertNotCount(0, $customers);
    }
}