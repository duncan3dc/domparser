<?php

namespace duncan3dc\Dom;

use function assert;

abstract class AbstractBase
{
    /** @var \DOMDocument|\DOMElement */
    protected $dom;


    /**
     * Create a new instance.
     *
     * @param \DOMDocument|\DOMElement $dom The element to wrap
     */
    public function __construct(\DOMNode $dom)
    {
        $this->dom = $dom;
    }


    /**
     * Get the internal instance we are wrapping.
     *
     * @return \DOMNode
     */
    public function getDomNode(): \DOMNode
    {
        return $this->dom;
    }


    abstract protected function newElement(\DOMNode $element);


    /**
     * Get elements from anywhere underneath this element.
     *
     * @param string $name The name of the elements to look for
     *
     * @return ElementInterface[]
     */
    public function getTags(string $name): array
    {
        $elements = [];

        $list = $this->dom->getElementsByTagName($name);
        foreach ($list as $element) {
            $elements[] = $this->newElement($element);
        }

        return $elements;
    }


    /**
     * Get elements from anywhere underneath this element.
     *
     * @param string $name The name of the elements to look for
     *
     * @return ElementInterface[]
     */
    public function getElementsByTagName(string $name): array
    {
        return $this->getTags($name);
    }


    /**
     * Get an element from anywhere underneath this element.
     *
     * @param string $name The name of the element to look for
     *
     * @return ElementInterface|null
     */
    public function getTag(string $name, int $key = 0): ?ElementInterface
    {
        $elements = $this->dom->getElementsByTagName($name);

        if (!$element = $elements->item($key)) {
            return null;
        }

        return $this->newElement($element);
    }


    /**
     * Get an element from anywhere underneath this element.
     *
     * @param string $name The name of the element to look for
     *
     * @return ElementInterface|null
     */
    public function getElementByTagName(string $name, int $key = 0): ?ElementInterface
    {
        return $this->getTag($name, $key);
    }
}
