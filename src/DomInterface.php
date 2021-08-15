<?php

namespace duncan3dc\Dom;

interface DomInterface
{
    /**
     * @return ElementInterface[]
     */
    public function getTags(string $name): array;


    /**
     * @return ElementInterface[]
     */
    public function getElementsByTagName(string $name): array;


    public function getTag(string $name, int $key = 0): ?ElementInterface;


    public function getElementByTagName(string $name, int $key = 0): ?ElementInterface;


    public function toString(): string;
}
