<?php

namespace App\Models\Customer\Subscription;


class SubscriptionManager
{
    public function updateNextOrderDate($id) {
        /**
         * @var $subscription Subscription
         */
        $subscription = Subscription::find($id);

        $nextOrderDate = new \DateTime($subscription->getNextorderDate());
        $dateInterval = new \DateInterval("P". $subscription->getDayiteration() . "D");
        $nextOrderDate->add( $dateInterval );

        $subscription->setNextorderDate($nextOrderDate->format("Y-m-d"));
        $subscription->save(['nextorder_date']);

        return $subscription;
    }

    public function setDayIteration($subscriptionData) {
        /**
         * @var $subscription Subscription
         */
        $subscription = Subscription::find($subscriptionData['id']);
        $subscription->setDayiteration($subscriptionData['day_iteration']);

        $subscription->save(['day_iteration']);

        return $subscription;
    }
}