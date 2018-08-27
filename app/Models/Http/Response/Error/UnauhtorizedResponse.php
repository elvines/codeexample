<?php

namespace App\Models\Http\Response\Error;


class UnauhtorizedResponse extends AbstractErrorResponse
{
    protected $code = 401;
}