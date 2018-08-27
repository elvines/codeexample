<?php

namespace App\Models\Http\Response\Ok;
use App\Models\Account\Brand;
use App\Models\Account\User;
use Auth;

class ViewResponse extends OkResponse
{
    protected $view;

    public function setView($view) {
        $this->view = $view;

        return $this;
    }

    public function render() {
        return response()->view($this->view, $this->getData(), $this->getCode(), $this->getHeaders());
    }
}