<?php

namespace duncan3dc\DomParser;

class XmlParser extends XmlBase
{
    use Parser;
    public $xml;


    public function __construct($param)
    {
        parent::__construct(new \DomDocument());

        $this->dom->preserveWhiteSpace = false;

        $this->xml = $this->getData($param);
    }
}
