<?php

namespace duncan3dc\Dom;

/**
 * @template T of ElementInterface
 * @extends DomInterface<ElementInterface>
 */
interface ElementInterface extends DomInterface
{
    public function getDomNode(): \DOMNode;

    /**
     * @return <T>
     */
    public function getParent(): ElementInterface;


    /**
     * @return array<<T>>
     */
    public function getChildren(): array;


    public function getValue(): string;


    /**
     * @return <T>
     */
    public function nodeValue(string $value): ElementInterface;


    public function hasAttribute(string $name): bool;


    public function getAttribute(string $name): string;


    /**
     * @return <T>
     */
    public function setAttribute(string $name, string $value): ElementInterface;


    /**
     * @return array<string|int,mixed>
     */
    public function getAttributes(): array;


    /**
     * @param <T> $element
     *
     * @return <T>
     */
    public function removeChild(ElementInterface $element): ElementInterface;


    /**
     * Get the value of this tag (same as getValue())
     *
     * @return string
     */
    public function __toString(): string;
}
