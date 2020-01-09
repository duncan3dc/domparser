<?php

namespace duncan3dc\Dom\Html;

use duncan3dc\Dom\ParserTrait;

/**
 * Parse html.
 */
class Parser extends AbstractBase
{
    use ParserTrait;

    /**
     * @var string The html string we are parsing.
     */
    public $html;


    /**
     * Create a new parser.
     *
     * @param string $param Can either be a url with an html response or string containing html
     */
    public function __construct($param)
    {
        parent::__construct(new \DOMDocument());

        $this->dom->preserveWhiteSpace = false;

        $this->html = $this->getData($param);
    }


    public function getElementById($id)
    {
        if (!$element = $this->dom->getElementById($id)) {
            return false;
        }

        return $this->newElement($element);
    }
}