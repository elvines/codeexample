<?php

namespace Tests\Unit\Customer;


use App\Models\Customer\Customer;
use App\Models\Customer\CustomerValidator;
use Tests\CustomerTestCase;

class CustomerValidatorTest extends CustomerTestCase
{
    public function test_customer_id_equals_zero() {
        $customerData = [
            'id' => 0,
        ];

        $validator = new CustomerValidator();
        $validator->validateCustomer($customerData);

        $this->assertTrue($validator->fails());
    }

    public function test_customer_id_is_real() {
        $customer = Customer::first();

        $customerData = [
            'id' => $customer->getId(),
        ];

        $validator = new CustomerValidator();
        $validator->validateCustomer($customerData);

        $this->assertFalse($validator->fails());
    }

    public function test_customer_id_overflow() {
        $customerData = [
            'id' => 1000,
        ];

        $validator = new CustomerValidator();
        $validator->validateCustomer($customerData);

        $this->assertTrue($validator->fails());
    }
}