<?php

namespace duncan3dc\DomParser;

class Element extends Base {


    public function __construct($dom,$mode) {

        parent::__construct($dom,$mode);

    }


    public function __get($key) {

        $value = $this->dom->$key;

        switch($key) {
            case "parentNode":
                return new Element($value,$this->mode);
            break;
            case "nodeValue":
                return trim($value);
            break;
        }

        return $value;
    }


    public function getAttribute($name) {
        return $this->dom->getAttribute($name);
    }


    public function getAttributes() {
        $attributes = array();
        foreach($this->dom->attributes as $attr) {
            $attributes[$attr->name] = $attr->value;
        }
        return $attributes;
    }


}
