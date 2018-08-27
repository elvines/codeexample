<?php

namespace App\Models\Customer\Order;

use App\Models\Customer\Customer;
use App\Models\Validator\AbstractValidator;

class OrderValidator extends AbstractValidator
{

    /**
     * @param $orderData
     * @return mixed
     */
    public function validateStoreBasedOnSubscriptionDate($orderData) {
        $validateFields = [
            'customer_id' => 'required|int|min:1|exists:customer,id',
            'total' => 'required|int|min:1',
        ];

        $this->validate($orderData, $validateFields);

        if ($this->fails()) {
            return false;
        }

        $customer = Customer::find($orderData['customer_id']);

        if (!$customer->getSubscription()) {
            $this->addError("subscription.not_found");
            return false;
        }

        return true;
    }
}