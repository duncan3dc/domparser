<?php

namespace duncan3dc\Dom;

/**
 * @template T of ElementInterface
 */
interface DomInterface
{
    /**
     * @return array<<T>>
     */
    public function getTags(string $name): array;


    /**
     * @return array<<T>>
     */
    public function getElementsByTagName(string $name): array;


    /**
     * @return ?<T>
     */
    public function getTag(string $name, int $key = 0): ?ElementInterface;


    /**
     * @return ?<T>
     */
    public function getElementByTagName(string $name, int $key = 0): ?ElementInterface;


    public function toString(): string;
}
