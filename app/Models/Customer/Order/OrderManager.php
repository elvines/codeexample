<?php

namespace App\Models\Customer\Order;

use App\Models\Customer\Customer;

class OrderManager
{
    public function storeBasedOnSubscriptionDate(array $orderData) {
        $order = new Order($orderData);

        $customer = $order->getCustomer();
        $subscription = $customer->getSubscription();

        if (!$subscription) {
            throw new \ErrorException("Subscription not found");
        }

        $order->subscription()->associate($subscription);

        /**
         * @comment
         *
         * In real environment subscriptions have recurring payment
         * We send some requests to the payment system via cron job
         * and after we receive a response payment success/declined.
         * This is where we decide order status and set a paid date,
         * but since it's an artificial environment we just assume that
         * the payment was successful when we create an order
         *
         * Also NextorderDate helps cron to determine the date when order has to be created
         * Everything is really out of context here, sorry
         *
         */

        $order->setPaidDate($subscription->getNextorderDate());
        $order->setStatus(Order::STATUS_PAID);
        $order->save();

        return $order;
    }

    public function getCustomerLastPaidOrder($id) {
        /**
         * @var $customer Customer
         */
        $customer = Customer::find($id);

        $order = $customer->orders()
            ->where("status", Order::STATUS_PAID)
            ->orderByDesc("paid_date")
            ->first();

        return $order;
    }
}