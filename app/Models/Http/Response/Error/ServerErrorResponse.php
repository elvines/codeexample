<?php

namespace App\Models\Http\Response\Error;

class ServerErrorResponse extends AbstractErrorResponse
{
    public function __construct()
    {
        $this->addError("server.fault");
    }

    protected $code = 500;
}