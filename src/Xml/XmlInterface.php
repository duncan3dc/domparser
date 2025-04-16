<?php

namespace duncan3dc\Dom\Xml;

use duncan3dc\Dom\DomInterface;

interface XmlInterface extends DomInterface
{
    /**
     * Get elements that are part of a particular namespace.
     *
     * @param string $ns The namespace the elements are in
     * @param string $name The name of the elements to look for
     *
     * @return ElementInterface[]
     */
    public function getTagsNS(string $ns, string $name): array;


    /**
     * Get elements that are part of a particular namespace.
     *
     * @param string $ns The namespace the elements are in
     * @param string $name The name of the elements to look for
     *
     * @return ElementInterface[]
     */
    public function getElementsByTagNameNS(string $ns, string $name): array;


    /**
     * Get a single element that is part of a particular namespace.
     *
     * @param string $ns The namespace the element is in
     * @param string $name The name of the element to look for
     *
     * @return ?ElementInterface
     */
    public function getTagNS(string $ns, string $name, int $key = 0): ?ElementInterface;


    /**
     * Get a single element that is part of a particular namespace.
     *
     * @param string $ns The namespace the element is in
     * @param string $name The name of the element to look for
     *
     * @return ?ElementInterface
     */
    public function getElementByTagNameNS(string $ns, string $name, int $key = 0): ?ElementInterface;
}
