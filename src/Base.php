<?php

namespace duncan3dc\DomParser;

class Base {

    public  $dom;
    public  $mode;


    public function __construct($dom,$mode) {

        $this->dom = $dom;
        $this->mode = $mode;

    }


    public function getElementById($id) {

        if(!$element = $this->dom->getElementById($id)) {
            return false;
        }

        return new Element($element,$this->mode);
    }


    public function getTags($tagName) {

        $elements = [];

        $list = $this->dom->getElementsByTagName($tagName);
        foreach($list as $element) {
            $elements[] = new Element($element,$this->mode);
        }

        return $elements;
    }


    public function getElementsByTagName($tagName) {
        return $this->getTags($tagName);
    }


    public function getTag($tagName,$key=0) {

        $elements = $this->dom->getElementsByTagName($tagName);

        if(!$element = $elements->item($key)) {
            return false;
        }

        return new Element($element,$this->mode);
    }


    public function getElementByTagName($tagName,$key=0) {
        return $this->getTag($tagName,$key);
    }


    public function getTagsNS($ns,$tagName) {

        $elements = [];

        $list = $this->dom->getElementsByTagNameNS($ns,$tagName);
        foreach($list as $element) {
            $elements[] = new Element($element,$this->mode);
        }

        return $elements;
    }


    public function getElementsByTagNameNS($ns,$tagName) {
        return $this->getTagsNS($ns,$tagName);
    }


    public function getTagNS($ns,$tagName,$key=0) {

        $elements = $this->dom->getElementsByTagNameNS($ns,$tagName);

        if(!$element = $elements->item($key)) {
            return false;
        }

        return new Element($element,$this->mode);
    }


    public function getElementByTagNameNS($ns,$tagName,$key=0) {
        return $this->getTagNS($ns,$tagName,$key);
    }


    public function getElementsByClassName($className,$limit=0) {

        if(!is_array($className)) {
            $className = [$className];
        }

        $return = [];

        $elements = $this->dom->getElementsByTagName("*");
        foreach($elements as $node) {
            if(!$node->hasAttributes()) {
                continue;
            }

            if(!$check = $node->attributes->getNamedItem("class")) {
                continue;
            }

            $classes = explode(" ",$check->nodeValue);
            $found = true;
            foreach($className as $val) {
                if(!in_array($val,$classes)) {
                    $found = false;
                    break;
                }
            }
            if($found) {
                $return[] = new Element($node,$this->mode);
                if($limit) {
                    if(!--$limit) {
                        break;
                    }
                }
            }

        }

        return $return;

    }


    public function getElementByClassName($className,$key=0) {

        $elements = $this->getElementsByClassName($className,$key+1);

        return $elements[$key];
    }


    public function output() {

        if(!$doc = $this->dom->ownerDocument) {
            $doc = $this->dom;
        }

        $doc->formatOutput = true;

        $method = "save" . strtoupper($this->mode);

        return $doc->$method($this->dom);

    }


    public function xpath($path) {

        $xpath = new \DomXPath($this->dom);

        $list = $xpath->query($path);

        $return = [];
        foreach($list as $node) {
            $return[] = new Element($node,$this->mode);
        }

        return $return;

    }


}
