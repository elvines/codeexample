<?php

namespace App\Models\Customer\Subscription;


use App\Models\Validator\AbstractValidator;

class SubscriptionValidator extends AbstractValidator
{
    public function validateSubscription($subscriptionData) {

        $validateFields = [
            'id' => 'required|int|min:1|exists:subscription,id',
        ];

        $this->validate($subscriptionData, $validateFields);
    }

    public function validateSetDayIteration($subscriptionData) {

        $validateFields = [
            'id' => 'required|int|min:1|exists:subscription,id',
            'day_iteration' => 'required|int|min:1',
        ];

        $this->validate($subscriptionData, $validateFields);
    }
}