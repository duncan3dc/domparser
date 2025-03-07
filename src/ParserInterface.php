<?php

namespace duncan3dc\Dom;

/**
 * @template T of ElementInterface
 * @extends DomInterface<ElementInterface>
 */
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
     * @return array<T>
     */
    public function xpath(string $path): array;
}
