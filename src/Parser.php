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

        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL             =>  $param,
            CURLOPT_RETURNTRANSFER  =>  true,
            CURLOPT_FOLLOWLOCATION  =>  true,
        ]);

        $result = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if($result === false) {
            throw new \Exception($error);
        }

        return $result;

    }


}
