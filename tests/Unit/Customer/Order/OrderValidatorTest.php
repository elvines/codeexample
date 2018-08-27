<?php


namespace tests\Unit\Customer\Order;


use App\Models\Customer\Customer;
use App\Models\Customer\Order\OrderValidator;
use Tests\CustomerTestCase;

class OrderValidatorTest extends CustomerTestCase
{
    public function test_validate_customer_id_and_total_equals_zero() {
        $orderData = [
            'customer_id' => 0,
            'total' => 0
        ];

        $validator = new OrderValidator();
        $validator->validateStoreBasedOnSubscriptionDate($orderData);

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->getErrors());
    }

    public function test_valid_customer_id_and_total_equals_to_zero() {
        $customer = Customer::first();

        $orderData = [
            'customer_id' => $customer->getId(),
            'total' => 0
        ];

        $validator = new OrderValidator();
        $validator->validateStoreBasedOnSubscriptionDate($orderData);

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->getErrors());
    }

    public function test_customer_id_overflow() {
        $orderData = [
            'customer_id' => 2000,
            'total' => 10
        ];

        $validator = new OrderValidator();
        $validator->validateStoreBasedOnSubscriptionDate($orderData);

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->getErrors());
    }

    public function test_valid_customer_id_and_total() {
        $customer = Customer::has("subscription")->first();
        $orderData = [
            'customer_id' => $customer->getId(),
            'total' => 10
        ];

        $validator = new OrderValidator();
        $validator->validateStoreBasedOnSubscriptionDate($orderData);

        $this->assertFalse($validator->fails());
    }
}