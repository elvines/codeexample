<?php

namespace App\Models\Http\Response\Ok;

use App\Models\Http\Response\AbstractResponse;

abstract class AbstractOkResponse extends AbstractResponse
{
    protected $data = array();

    public function getReadyData()
    {
        return array("data" => $this->getData());
    }

    public function addData($key, $value) {
        if (isset($this->data[$key])) {
            throw new \Exception("Key $key is already set in response data");
        }

        $this->data[$key] = $value;

        return $this;
    }

    public function getData() {
        return $this->data;
    }

}