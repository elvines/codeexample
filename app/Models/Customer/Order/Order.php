<?php

namespace App\Models\Customer\Order;

use App\Models\Customer\Customer;
use App\Models\Customer\Subscription\Subscription;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    CONST STATUS_CREATED = 'created';
    CONST STATUS_PAID = 'paid';
    CONST STATUS_FAILED = 'failed';

    public $timestamps = false;

    protected $table = "order";

    protected $fillable = [
        'customer_id',
        'subscription_id',
        'total'
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer\Customer');
    }

    public function subscription() {
        return $this->belongsTo('App\Models\Customer\Subscription\Subscription');
    }

    /**
     * @return Subscription
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return Customer
     */
    public function getCustomer() {
        return $this->customer;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionId()
    {
        return $this->subscription_id;
    }

    /**
     * @param mixed $subscription_id
     */
    public function setSubscriptionId($subscription_id)
    {
        $this->subscription_id = $subscription_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getPaidDate()
    {
        return $this->paid_date;
    }

    /**
     * @param mixed $paid_date
     */
    public function setPaidDate($paid_date)
    {
        $this->paid_date = $paid_date;
    }



}
