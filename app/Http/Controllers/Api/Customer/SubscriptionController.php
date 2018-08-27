<?php


namespace App\Http\Controllers\Api\Customer;


use App\Http\Controllers\Controller;
use App\Models\Customer\Subscription\SubscriptionManager;
use App\Models\Customer\Subscription\SubscriptionValidator;
use App\Models\Http\Response\Error\BadRequestResponse;
use App\Models\Http\Response\Ok\OkResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     *
     * This should be a part of closed cron system but I'm making
     * an endpoint for this for those who read this could test it.
     *
     * No cron required here since it's just an example of work
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNextOrderDate(Request $request) {
        $subscriptionData = $request->get("subscription");

        $validator = new SubscriptionValidator();
        $validator->validateSubscription($subscriptionData);

        if ($validator->fails()) {
            $badRequestResponse = new BadRequestResponse();
            $badRequestResponse->setErrors($validator->getErrors());
            return $badRequestResponse->renderJson();
        }

        $subscriptionManager = new SubscriptionManager();
        $subscription = $subscriptionManager->updateNextOrderDate($subscriptionData['id']);

        $okResponse = new OkResponse();
        $okResponse->addData("subscription", $subscription);

        return $okResponse->renderJson();
    }

    public function updateDayIteration(Request $request) {
        $subscriptionData = $request->get("subscription");

        $validator = new SubscriptionValidator();
        $validator->validateSetDayIteration($subscriptionData);

        if ($validator->fails()) {
            $badRequestResponse = new BadRequestResponse();
            $badRequestResponse->setErrors($validator->getErrors());
            return $badRequestResponse->renderJson();
        }

        $subscriptionManager = new SubscriptionManager();
        $subscription = $subscriptionManager->setDayIteration($subscriptionData);

        $okResponse = new OkResponse();
        $okResponse->addData("subscription", $subscription);

        return $okResponse->renderJson();
    }
}