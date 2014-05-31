<?php

namespace duncan3dc\DomParser;

class XmlParser extends Parser {

    public  $xml;


    public function __construct($param) {

        parent::__construct("xml");

        $this->xml = $this->getData($param);

        libxml_use_internal_errors(true);
        $this->dom->loadXML($this->xml);
        $this->errors = libxml_get_errors();
        libxml_clear_errors();

    }


}
