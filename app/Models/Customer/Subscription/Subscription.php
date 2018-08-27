<?php

namespace App\Models\Customer\Subscription;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = "subscription";
    public $timestamps = false;

    protected $casts = [
        "active" => "boolean"
    ];

    public function customer() {
        return $this->belongsTo('App\Models\Customer\Customer');
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
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getNextorderDate()
    {
        return $this->nextorder_date;
    }

    /**
     * @param mixed $nextorder_date
     */
    public function setNextorderDate($nextorder_date)
    {
        $this->nextorder_date = $nextorder_date;
    }

    /**
     * @return mixed
     */
    public function getDayiteration()
    {
        return $this->day_iteration;
    }

    /**
     * @param mixed $dayiteration
     */
    public function setDayiteration($dayiteration)
    {
        $this->day_iteration = $dayiteration;
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


}
