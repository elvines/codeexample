<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;

use App\Models\Customer\CustomerValidator;
use App\Models\Customer\Order\OrderManager;
use App\Models\Customer\Order\OrderValidator;
use App\Models\Http\Response\Error\BadRequestResponse;
use App\Models\Http\Response\Ok\OkResponse;
use \Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeBasedOnSubscriptionDate(Request $request)
    {
        $validator = new OrderValidator();

        $orderData = $request->get("order");

        $validator->validateStoreBasedOnSubscriptionDate($orderData);

        if ($validator->fails()) {
            $badRequestResponse = new BadRequestResponse();
            $badRequestResponse->setErrors($validator->getErrors());
            return $badRequestResponse->renderJson();
        }

        $orderManager = new OrderManager();
        $order = $orderManager->storeBasedOnSubscriptionDate($orderData);

        $okResponse = new OkResponse();
        $okResponse->addData("order", $order);

        return $okResponse->renderJson();
    }

    /**
     * @param $id CustomerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastPaidOrder($id)
    {
        $customerData = ['id' => $id];

        $validator = new CustomerValidator();
        $validator->validateCustomer($customerData);

        if ($validator->fails()) {
            $badRequestResponse = new BadRequestResponse();
            $badRequestResponse->setErrors($validator->getErrors());
            return $badRequestResponse->renderJson();
        }

        $orderManager = new OrderManager();
        $order = $orderManager->getCustomerLastPaidOrder($id);

        $okResponse = new OkResponse();
        $okResponse->addData("order", $order);

        return $okResponse->renderJson();
    }

}
