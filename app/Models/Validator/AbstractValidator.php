<?php

namespace App\Models\Validator;
use Validator;
abstract class AbstractValidator
{

    protected $fails = false;
    protected $errors = [];

    public function fails() {
        return $this->fails;
    }

    public function getErrors() {
        return $this->errors;
    }

    protected function addError($value) {
        if (!$this->fails) {
            $this->fails = true;
        }

        $this->errors[] = $value;
    }

    /**
     * @param $requestData array
     * @param $validateFields array
     * @return mixed
     */
    protected function validate($requestData, $validateFields) {
        if (empty($requestData)) {
            throw new \BadMethodCallException("Request data is empty, nothing to validate");
        }

        $validator = Validator::make($requestData, $validateFields, $this->getMessages());
        $this->processErrors($validator);
    }

    protected function processErrors(\Illuminate\Validation\Validator $validator) {
        $this->fails = $validator->fails();
        $this->errors = str_replace(" ", "_", array_flatten($validator->errors()->toArray()));
    }

    protected function getMessages() {
        return [
            'required' => ":attribute.required",
            'max' => ":attribute.max_length",
            'unique' => ":attribute.unique",
            'email' => ":attribute.invalid",
            'min' => ":attribute.min_length",
            'confirmed' => ":attribute.confirmation_required",
            'integer' => ":attribute.int_required",
            'string' => ":attribute.str_required",
            'url' => ":attribute.url_required",
            'date' => ":attribute.date_invalid",
            'date_format' => ":attribute.time_invalid",
            'array' => ":attribute.array_required",
            'date_multi_format' => ":attribute.date_or_time_invalid",
            'mimes' => ":attribute.mime_invalid",
            'exists' => ":attribute.not_found"
        ];
    }
}