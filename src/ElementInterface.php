<?php

namespace duncan3dc\Dom;

interface ElementInterface extends DomInterface
{

    public function getDomNode(): \DOMNode;

    public function getParent(): ElementInterface;


    public function getChildren(): array;


    public function getValue(): string;


    public function nodeValue(string $value): ElementInterface;


    public function hasAttribute(string $name): bool;


    public function getAttribute(string $name): string;


    public function setAttribute(string $name, string $value): ElementInterface;


    public function getAttributes(): array;


    public function removeChild(ElementInterface $element): ElementInterface;


    /**
     * Get the value of this tag (same as getValue())
     *
     * @return string
     */
    public function __toString(): string;
}
