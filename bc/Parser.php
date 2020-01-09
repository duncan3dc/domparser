<?php

namespace duncan3dc\DomParser;

/**
 * Shared methods for the parsers.
 * @deprecated Use \duncan3dc\Dom\ParserTrait
 */
trait Parser
{
    /**
     * @var array $errors An array of errors that occurred during parsing.
     */
    public $errors = [];

    /**
     * Get the content for parsing.
     *
     * Creates an internal dom instance.
     *
     * @param string $data The xml/html
     *
     * @return string The xml/html
     */
    protected function getData($data)
    {
        $method = "load" . strtoupper($this->mode);

        libxml_use_internal_errors(true);
        $this->dom->$method($data);
        $this->errors = libxml_get_errors();
        libxml_clear_errors();

        return $data;
    }


    /**
     * Get elements using an xpath selector.
     *
     * @param string $path The xpath selector
     *
     * @return Element[]
     */
    public function xpath($path)
    {
        $xpath = new \DOMXPath($this->dom);

        $list = $xpath->query($path);

        $return = [];
        foreach ($list as $node) {
            $return[] = $this->newElement($node);
        }

        return $return;
    }
}
