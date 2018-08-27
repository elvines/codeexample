<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer\Subscription\Subscription;
use App\Models\Customer\Order\Order;

class Customer extends Model
{
    protected $table = "customer";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'active'
    ];

    protected $casts = [
        "active" => "boolean"
     ];

    public function orders() {
        return $this->hasMany('App\Models\Customer\Order\Order');
    }

    public function subscription() {
        return $this->hasOne('App\Models\Customer\Subscription\Subscription');
    }

    /**
     * @return Subscription
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return Order[]
     */
    public function getOrders() {
        return $this->orders;
    }

    /**
     * @return mixed
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param mixed $subscriptions
     */
    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



}
