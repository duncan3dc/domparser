<?php

namespace duncan3dc\Dom;

abstract class AbstractBase
{
    /** @var \DOMDocument|\DOMElement */
    protected $dom;

    public $mode;

    abstract protected function newElement($element);

    public function __construct($dom, $mode)
    {
        $this->dom = $dom;
        $this->mode = $mode;
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


    public function getTags($tagName)
    {
        $elements = [];

        $list = $this->dom->getElementsByTagName($tagName);
        foreach ($list as $element) {
            $elements[] = $this->newElement($element);
        }

        return $elements;
    }


    public function getElementsByTagName($tagName)
    {
        return $this->getTags($tagName);
    }


    public function getTag($tagName, $key = 0)
    {
        $elements = $this->dom->getElementsByTagName($tagName);

        if (!$element = $elements->item($key)) {
            return false;
        }

        return $this->newElement($element);
    }


    public function getElementByTagName($tagName, $key = 0)
    {
        return $this->getTag($tagName, $key);
    }
}
