<?php

namespace duncan3dc\DomParser;

trait Element
{
    public function __toString()
    {
        return $this->nodeValue;
    }


    public function __get($key)
    {
        $value = $this->dom->$key;

        switch ($key) {

            case "parentNode":
                return $this->newElement($value);

            case "childNodes":
                $elements = [];
                foreach ($value as $element) {
                    $elements[] = $this->newElement($element);
                }
                return $elements;

            case "nodeValue":
                return trim($value);
        }

        return $value;
    }


    public function nodeValue($value)
    {
        $this->dom->nodeValue = "";

        $node = $this->dom->ownerDocument->createTextNode($value);

        $this->dom->appendChild($node);
    }


    public function getAttribute($name)
    {
        return $this->dom->getAttribute($name);
    }


    public function setAttribute($name, $value)
    {
        return $this->dom->setAttribute($name, $value);
    }


    public function getAttributes()
    {
        $attributes = [];
        foreach ($this->dom->attributes as $attr) {
            $attributes[$attr->name] = $attr->value;
        }
        return $attributes;
    }
}
