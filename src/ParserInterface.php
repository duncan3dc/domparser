<?php

namespace duncan3dc\Dom;

interface ParserInterface
{


    /**
     * Get any errors raised when parsing this object's XML/HTML.
     *
     * @return \LibXMLError[]
     */
    public function getErrors(): array;
}
