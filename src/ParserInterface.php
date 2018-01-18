<?php

namespace duncan3dc\Dom;

interface ParserInterface extends DomInterface
{


    /**
     * Get any errors raised when parsing this object's XML/HTML.
     *
     * @return \LibXMLError[]
     */
    public function getErrors(): array;


    /**
     * Get elements using an xpath selector.
     *
     * @param string $path The xpath selector
     *
     * @return ElementInterface[]
     */
    public function xpath(string $path): array;
}
