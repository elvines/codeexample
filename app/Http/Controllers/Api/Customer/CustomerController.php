<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerManager;
use App\Models\Http\Response\Ok\OkResponse;

class CustomerController extends Controller
{

    /**
     * @comment These two actions should be refactored to one "getCollectionAction"
     * with ability to apply filters like having atleast one paid order and having subscription in "status" variable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCollectionWithPaidOrder() {
        $customerManager = new CustomerManager();

        $customers = $customerManager->getCollectionWithPaidOrder();

        $okResponse = new OkResponse();
        $okResponse->addData("customers", $customers);

        return $okResponse->renderJson();
    }

    public function getCollectionWithActiveSubscriptionAndPaidOrder() {
        $customerManager = new CustomerManager();

        $customers = $customerManager->getCollectionWithActiveSubscriptionAndPaidOrder();

        $okResponse = new OkResponse();
        $okResponse->addData("customers", $customers);

        return $okResponse->renderJson();
    }
}