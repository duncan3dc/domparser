<?php

namespace duncan3dc\DomParser;

class HtmlParser extends Parser
{
    public  $html;


    public function __construct($param)
    {
        parent::__construct("html");

        $this->html = $this->getData($param);

        libxml_use_internal_errors(true);
        $this->dom->loadHTML($this->html);
        $this->errors = libxml_get_errors();
        libxml_clear_errors();
    }
}
