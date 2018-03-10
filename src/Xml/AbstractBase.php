<?php

namespace duncan3dc\Dom\Xml;

class AbstractBase extends \duncan3dc\Dom\AbstractBase
{


    /**
     * Create a new element.
     *
     * @param \DOMNode $element The element to wrap.
     *
     * @return ElementInterface
     */
    protected function newElement(\DOMNode $element): ElementInterface
    {
        return new Element($element);
    }


    /**
     * @inheritDoc
     */
    public function getTagsNS(string $ns, string $name): array
    {
        $elements = [];

        $list = $this->dom->getElementsByTagNameNS($ns, $name);
        foreach ($list as $element) {
            $elements[] = $this->newElement($element);
        }

        return $elements;
    }


    /**
     * @inheritDoc
     */
    public function getElementsByTagNameNS(string $ns, string $name): array
    {
        return $this->getTagsNS($ns, $name);
    }


    /**
     * @inheritDoc
     */
    public function getTagNS(string $ns, string $name, int $key = 0): ?ElementInterface
    {
        $elements = $this->dom->getElementsByTagNameNS($ns, $name);

        if (!$element = $elements->item($key)) {
            return null;
        }

        return $this->newElement($element);
    }


    /**
     * @inheritDoc
     */
    public function getElementByTagNameNS(string $ns, string $name, int $key = 0): ?ElementInterface
    {
        return $this->getTagNS($ns, $name, $key);
    }


    /**
     * Serialize this element using pretty formatting.
     *
     * @return string
     */
    public function toString(): string
    {
        if ($this->dom instanceof \DOMDocument) {
            $doc = $this->dom;
        } else {
            $doc = $this->dom->ownerDocument;
        }

        $doc->formatOutput = true;

        return $doc->saveXML($this->dom);
    }
}
