<?php

namespace App\Models\Http\Response;

abstract class AbstractResponse
{
    protected $code;
    protected $headers = array();

    public function render() {
        $data = $this->getReadyData();

        return response($data, $this->getCode())->withHeaders($this->getHeaders());
    }

    public function renderJson(){
        $data = $this->getReadyData();
        $data['code'] = $this->getCode();

        return response()->json($data, $this->getCode(), $this->getHeaders());
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getCode() {
        if (empty($this->code)) {
            throw new \BadMethodCallException("HttpResponse requires response code to answer");
        }

        return $this->code;
    }

    abstract protected function getReadyData();
}