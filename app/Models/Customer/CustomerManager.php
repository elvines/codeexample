<?php

namespace App\Models\Customer;


use App\Models\Customer\Order\Order;

class CustomerManager
{
    /**
     * @comment Get collection of customers that have atleast one available paid order
     *
     * @return Customer[]
     */
    public function getCollectionWithPaidOrder() {
        $customers = Customer::select("customer.*")
            ->join("order", 'order.customer_id', 'customer.id')
            ->where("order.status", Order::STATUS_PAID)
            ->groupBy("customer.id")
            ->havingRaw("count(order.id) > 1 ")
            ->get();

        return $customers;
    }

    /**
     * @comment Get collection of customers that have atleast one available paid order and active subscription
     *
     * @return Customer[]
     */
    public function getCollectionWithActiveSubscriptionAndPaidOrder() {
        $customers = Customer::select("customer.*")
            ->join("order", 'order.customer_id', 'customer.id')
            ->where("order.status", Order::STATUS_PAID)
            ->join("subscription", 'subscription.customer_id', 'customer.id')
            ->where("subscription.active", true)
            ->groupBy("customer.id")
            ->havingRaw("count(order.id) > 1 ")
            ->get();

        return $customers;
    }
}