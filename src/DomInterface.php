<?php

namespace duncan3dc\Dom;

interface DomInterface
{
    public function getTags(string $name): array;


    public function getElementsByTagName(string $name): array;


    public function getTag(string $name, int $key = 0): ?ElementInterface;


    public function getElementByTagName(string $name, int $key = 0): ?ElementInterface;


    public function toString(): string;
}
