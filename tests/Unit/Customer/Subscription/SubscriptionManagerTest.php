<?php

namespace tests\Unit\Customer\Subscription;


use App\Models\Customer\Subscription\Subscription;
use App\Models\Customer\Subscription\SubscriptionManager;
use Tests\CustomerTestCase;

class SubscriptionManagerTest extends CustomerTestCase
{
    /**
     * @comment Testing update subscription next_orderdate
     */
    public function test_update_next_order_date() {
        $oldSubscription = Subscription::first();

        $manager = new SubscriptionManager();

        $resultSubscription = $manager->updateNextOrderDate($oldSubscription->getId());

        $this->assertInstanceOf('App\Models\Customer\Subscription\Subscription', $resultSubscription);

        $newSubscription = Subscription::find($oldSubscription->getId());

        $this->assertNotEquals($oldSubscription->getNextorderDate(), $newSubscription->getNextorderDate());

        $nextOrderDate = new \DateTime($oldSubscription->getNextorderDate());
        $dateInterval = new \DateInterval("P". $oldSubscription->getDayiteration() . "D");
        $nextOrderDate->add( $dateInterval );

        $this->assertEquals($newSubscription->getNextorderDate(), $nextOrderDate->format("Y-m-d"));
    }

    public function test_set_day_iteration() {
        $oldSubscription = Subscription::first();

        $subscriptionData = [
            'id' => $oldSubscription->getId(),
            'day_iteration' => 60
        ];

        $manager = new SubscriptionManager();
        $subscription = $manager->setDayIteration($subscriptionData);

        /**
         * @comment Check that subscription didn't have the same day iteration that we did set
         */
        $this->assertNotEquals($subscription->getDayiteration(), $oldSubscription->getDayIteration());

        $subscriptionCheck = Subscription::find($subscriptionData['id']);
        $this->assertEquals($subscriptionCheck->getDayiteration(), $subscription->getDayIteration());
    }
}