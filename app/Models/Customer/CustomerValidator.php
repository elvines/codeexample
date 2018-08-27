<?php

namespace App\Models\Customer;


use App\Models\Validator\AbstractValidator;

class CustomerValidator extends AbstractValidator
{
    public function validateCustomer($customerData) {
        $validateFields = [
            'id' => 'required|int|min:1|exists:customer,id',
        ];

        $this->validate($customerData, $validateFields);
    }
}