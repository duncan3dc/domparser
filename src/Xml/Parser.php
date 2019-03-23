<?php

namespace duncan3dc\Dom\Xml;

use duncan3dc\Dom\ParserInterface;
use duncan3dc\Dom\ParserTrait;

use function libxml_clear_errors;
use function libxml_get_errors;
use function libxml_use_internal_errors;

/**
 * Parse xml.
 */
class Parser extends AbstractBase implements ParserInterface
{
    use ParserTrait;

    /** @var \DOMDocument */
    protected $dom;

    /** @var \LibXMLError[] */
    private $errors = [];


    /**
     * Create a new parser.
     *
     * @param string $xml
     */
    public function __construct(string $xml)
    {
        parent::__construct(new \DOMDocument());

        $this->dom->preserveWhiteSpace = false;

        libxml_use_internal_errors(true);
        $this->dom->loadXML($xml);
        $this->errors = libxml_get_errors();
        libxml_clear_errors();
    }


    /**
     * @inheritdoc
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
