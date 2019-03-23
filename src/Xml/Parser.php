<?php

namespace duncan3dc\Dom\Xml;

use duncan3dc\Dom\ParserTrait;

/**
 * Parse xml.
 */
class Parser extends AbstractBase
{
    use ParserTrait;

    /** @var \DOMDocument */
    protected $dom;

    /**
     * @var string The xml string we are parsing.
     */
    public $xml;


    /**
     * Create a new parser.
     *
     * @param string $param Can either be a url with an xml response or string containing xml
     */
    public function __construct($param)
    {
        parent::__construct(new \DOMDocument());

        $this->dom->preserveWhiteSpace = false;

        $this->xml = $this->getData($param);
    }
}
