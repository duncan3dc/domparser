<?php

namespace duncan3dc\Dom\Html;

use duncan3dc\Dom\DomInterface;

interface HtmlInterface extends DomInterface
{


    /**
     * @param string|array<string> $name
     *
     * @return ElementInterface[]
     */
    public function getElementsByClassName($name, int $limit = 0): array;


    /**
     * @param string|array<string> $name
     */
    public function getElementByClassName($name, int $key = 0): ?ElementInterface;


    /**
     * @return array<string,string>
     */
    public function parseForm(): array;
}
