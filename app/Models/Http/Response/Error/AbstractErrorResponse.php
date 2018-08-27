<?php

namespace App\Models\Http\Response\Error;

use App\Models\Http\Response\AbstractResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;

abstract class AbstractErrorResponse extends AbstractResponse
{
    protected $errors = array();

    public function getErrors() {
        return $this->errors;
    }

    public function setErrors(array $errors) {
        $this->errors = $errors;
    }

    public function addError($key, $value = null) {

        if ($value) {
            $this->errors[$key] = $value;
        } else {
            $this->errors[] = $key;
        }
    }

    protected function getReadyData()
    {
        return [
            'errors' => $this->getErrors()
        ];
    }
}