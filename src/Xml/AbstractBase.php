<?php

namespace duncan3dc\Dom\Xml;

class AbstractBase extends \duncan3dc\Dom\AbstractBase
{


    protected function newElement($element): ElementInterface
    {
        return new Element($element);
    }


    public function getTagsNS(string $ns, string $name): array
    {
        $elements = [];

        $list = $this->dom->getElementsByTagNameNS($ns, $name);
        foreach ($list as $element) {
            $elements[] = $this->newElement($element);
        }

        return $elements;
    }


    public function getElementsByTagNameNS(string $ns, string $name): array
    {
        return $this->getTagsNS($ns, $name);
    }


    public function getTagNS(string $ns, string $name, int $key = 0): ?ElementInterface
    {
        $elements = $this->dom->getElementsByTagNameNS($ns, $name);

        if (!$element = $elements->item($key)) {
            return null;
        }

        return $this->newElement($element);
    }


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
