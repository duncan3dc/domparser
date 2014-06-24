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


    public function nodeValue($value) {

        $this->dom->nodeValue = "";

        $node = $this->dom->ownerDocument->createTextNode($value);

        $this->dom->appendChild($node);

    }


    public function getAttribute($name) {
        return $this->dom->getAttribute($name);
    }


    public function setAttribute($name,$value) {
        return $this->dom->setAttribute($name,$value);
    }


    public function getAttributes() {
        $attributes = [];
        foreach($this->dom->attributes as $attr) {
            $attributes[$attr->name] = $attr->value;
        }
        return $attributes;
    }


}
