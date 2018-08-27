<?php

namespace App\Models\Http\Response\Error;

class NotFoundResponse extends AbstractErrorResponse
{
    protected $code = 404;

    public function render()
    {
        return response()->view("main.404", $this->getErrors(), $this->getCode(), $this->getHeaders());
    }
}