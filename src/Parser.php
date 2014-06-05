<?php

namespace duncan3dc\DomParser;
use \duncan3dc\Helpers\Helper;

class Parser extends Base {

    public $errors = [];


    public function __construct($mode) {

        parent::__construct(new \DomDocument(),$mode);

        $this->dom->preserveWhiteSpace = false;

    }


    protected function getData($param) {

        if(substr($param,0,4) != "http") {
            return $param;
        }

        return Helper::curl($param);

    }


}
