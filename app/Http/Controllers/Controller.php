<?php

namespace App\Http\Controllers;

use App\Models\Http\Response\Error\ServerErrorResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function callAction($method, $parameters)
    {
        try {
            $result = parent::callAction($method, $parameters);
            return $result;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());

            $serverErrorResponse = new ServerErrorResponse();


            if (env("DEBUG_MODE", true)) {
                $serverErrorResponse->addError("message", $e->getMessage());
                $serverErrorResponse->addError("stacktrace", $e->getTraceAsString());
            }

            return $serverErrorResponse->render();
        }
    }
}
