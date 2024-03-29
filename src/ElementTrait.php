<?php

namespace duncan3dc\Dom;

use function assert;

/**
 * @property array $childNodes
 * @property string $nodeValue
 * @property self $parentNode
 */
trait ElementTrait
{
    public function __toString(): string
    {
        return $this->nodeValue;
    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        if ($key === "parentNode") {
            return $this->getParent();
        }

        if ($key === "childNodes") {
            return $this->getChildren();
        }

        if ($key === "nodeValue") {
            return $this->getValue();
        }

        return $this->dom->$key;
    }


    public function getParent(): ElementInterface
    {
        $value = $this->dom->parentNode;

        assert($value instanceof \DOMDocument || $value instanceof \DOMElement);

        return $this->newElement($value);
    }


    /**
     * @return ElementInterface[]
     */
    public function getChildren(): array
    {
        $elements = [];

        if ($this->dom->hasChildNodes()) {
            foreach ($this->dom->childNodes as $node) {
                $elements[] = $this->newElement($node);
            }
        }

        return $elements;
    }


    public function getValue(): string
    {
        return trim($this->dom->nodeValue);
    }


    public function nodeValue(string $value): ElementInterface
    {
        $this->dom->nodeValue = "";

        assert($this->dom->ownerDocument instanceof \DOMDocument);
        $node = $this->dom->ownerDocument->createTextNode($value);

        $this->dom->appendChild($node);

        return $this;
    }


    public function hasAttribute(string $name): bool
    {
        return $this->dom->hasAttribute($name);
    }


    public function getAttribute(string $name): string
    {
        return $this->dom->getAttribute($name);
    }


    public function setAttribute(string $name, string $value): ElementInterface
    {
        $this->dom->setAttribute($name, $value);

        return $this;
    }


    /**
     * @return array<string|int,mixed>
     */
    public function getAttributes(): array
    {
        $attributes = [];
        assert($this->dom->attributes instanceof \DOMNamedNodeMap);
        foreach ($this->dom->attributes as $attr) {
            $attributes[$attr->name] = $attr->value;
        }
        return $attributes;
    }


    public function removeChild(ElementInterface $element): ElementInterface
    {
        $this->dom->removeChild($element->getDomNode());

        return $this;
    }
}
