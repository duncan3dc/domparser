<?php

namespace duncan3dc\DomParser;

use duncan3dc\Helpers\Helper;

trait Parser
{
    public $errors = [];

    protected function getData($param)
    {
        if (substr($param, 0, 4) == "http") {
            $data = Helper::curl($param);
        } else {
            $data = $param;
        }

        $method = "load" . strtoupper($this->mode);

        libxml_use_internal_errors(true);
        $this->dom->$method($data);
        $this->errors = libxml_get_errors();
        libxml_clear_errors();

        return $data;
    }
}
