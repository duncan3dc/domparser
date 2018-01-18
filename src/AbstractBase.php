<?php

namespace duncan3dc\Dom;

abstract class AbstractBase
{
    /** @var \DOMDocument|\DOMElement */
    protected $dom;

    abstract protected function newElement($element);

    public function __construct($dom)
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


    public function getTags(string $name): array
    {
        $elements = [];

        $list = $this->dom->getElementsByTagName($name);
        foreach ($list as $element) {
            $elements[] = $this->newElement($element);
        }

        return $elements;
    }


    public function getElementsByTagName(string $name): array
    {
        return $this->getTags($name);
    }


    public function getTag(string $name, int $key = 0): ?ElementInterface
    {
        $elements = $this->dom->getElementsByTagName($name);

        if (!$element = $elements->item($key)) {
            return null;
        }

        return $this->newElement($element);
    }


    public function getElementByTagName(string $name, int $key = 0): ?ElementInterface
    {
        return $this->getTag($name, $key);
    }
}
