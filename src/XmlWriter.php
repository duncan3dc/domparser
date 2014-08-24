<?php

namespace duncan3dc\DomParser;

class XmlWriter
{
    protected $dom;


    public function __construct(array $structure)
    {
        $this->dom = new \DomDocument();

        foreach ($structure as $key => $val) {
            $this->addElement($key, $val, $this->dom);
        }
    }


    public function getDomDocument()
    {
        return $this->dom;
    }


    public function toString($format = null)
    {
        if ($format) {
            $this->dom->formatOutput = true;
        }
        return $this->dom->saveXML();
    }


    public function addElement($name, $params, $parent)
    {
        $name = preg_replace("/_[0-9]+$/", "", $name);

        $element = $this->dom->createElement($name);

        if (!is_array($params)) {
            $this->setElementValue($element, $params);
        } else {
            foreach ($params as $key => $val) {
                if ($key == "_attributes") {
                    foreach ($val as $k => $v) {
                        $element->setAttribute($k, $v);
                    }
                } elseif ($key == "_value") {
                    $this->setElementValue($element, $val);
                } else {
                    $this->addElement($key, $val, $element);
                }
            }
        }

        $parent->appendChild($element);

        return $element;
    }


    public function setElementValue($element, $value)
    {
        $node = $this->dom->createTextNode($value);
        $element->appendChild($node);
    }


    public static function createXml($structure)
    {
        $writer = new static($structure);
        return trim($writer->toString());
    }


    public static function formatXml($structure)
    {
        $writer = new static($structure);
        return trim($writer->toString(true));
    }
}
