<?php

namespace duncan3dc\DomParser;

use duncan3dc\Helpers\Helper;

/**
 * Shared methods for the parsers.
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
     * @param string Can either be a url with an xml/html response or string containing xml/html
     *
     * @return string The xml/html either passed in or downloaded from the url
     */
    protected function getData($param)
    {
        if (substr($param, 0, 4) == "http") {
            $data = Helper::curl($param);
        } else {
            $data = $param;
        }

        $method = "load" . strtoupper($this->mode);

        libxml_use_internal_errors(true);
        $this->dom->$method($data);
        $this->errors = libxml_get_errors();
        libxml_clear_errors();

        return $data;
    }
}
