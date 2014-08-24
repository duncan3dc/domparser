<?php

namespace duncan3dc\DomParser;

class HtmlParser extends HtmlBase
{
    use Parser;
    public $html;


    public function __construct($param)
    {
        parent::__construct(new \DomDocument());

        $this->dom->preserveWhiteSpace = false;

        $this->html = $this->getData($param);
    }
}
