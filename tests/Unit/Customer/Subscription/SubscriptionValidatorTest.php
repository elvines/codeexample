<?php

namespace tests\Unit\Customer\Subscription;


use App\Models\Customer\Subscription\Subscription;
use App\Models\Customer\Subscription\SubscriptionValidator;
use Tests\CustomerTestCase;

class SubscriptionValidatorTest extends CustomerTestCase
{
    public function test_validate_subscription_with_valid_id() {
        $subscription = Subscription::first();
        $data = [
            'id' => $subscription->getId()
        ];

        $validator = new SubscriptionValidator();

        $validator->validateSubscription($data);
        $this->assertFalse($validator->fails());
        $this->assertEmpty($validator->getErrors());
    }

    public function test_validate_subscription_with_id_equals_zero() {
        $data = [
            'id' => 0
        ];

        $validator = new SubscriptionValidator();
        $validator->validateSubscription($data);
        $this->assertTrue($validator->fails());
        $this->assertNotEmpty($validator->getErrors());
    }

    public function test_validate_subscription_with_id_overflow() {
        $data = [
            'id' => 2000
        ];

        $validator = new SubscriptionValidator();
        $validator->validateSubscription($data);
        $this->assertTrue($validator->fails());
        $this->assertNotEmpty($validator->getErrors());
    }

    public function test_validate_set_day_iteration_to_10() {
        $subscription = Subscription::first();

        $data = [
            'id' => $subscription->getId(),
            'day_iteration' => 10
        ];

        $validator = new SubscriptionValidator();
        $validator->validateSetDayIteration($data);
        $this->assertFalse($validator->fails());
        $this->assertEmpty($validator->getErrors());
    }

    public function test_validate_set_day_iteration_subscription_id_equals_zero() {
        $data = [
            'id' => 0,
            'day_iteration' => 10
        ];

        $validator = new SubscriptionValidator();
        $validator->validateSetDayIteration($data);
        $this->assertTrue($validator->fails());
        $this->assertNotEmpty($validator->getErrors());
    }

    public function test_validate_set_day_iteration_to_zero() {
        $data = [
            'id' => 1,
            'day_iteration' => 0
        ];

        $validator = new SubscriptionValidator();
        $validator->validateSetDayIteration($data);
        $this->assertTrue($validator->fails());
        $this->assertNotEmpty($validator->getErrors());
    }

    public function test_validate_set_day_iteration_subscription_id_overflow() {
        $data = [
            'id' => 2000,
            'day_iteration' => 10
        ];

        $validator = new SubscriptionValidator();
        $validator->validateSetDayIteration($data);
        $this->assertTrue($validator->fails());
        $this->assertNotEmpty($validator->getErrors());
    }
}