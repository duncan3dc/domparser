<?php

namespace duncan3dc\DomParser;

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

        return (new \GuzzleHttp\Client())->get($param)->getBody();

    }


}
