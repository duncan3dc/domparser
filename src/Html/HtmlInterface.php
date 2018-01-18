<?php

namespace duncan3dc\Dom\Html;

use duncan3dc\Dom\DomInterface;

interface HtmlInterface extends DomInterface
{
    public function getElementsByClassName($name, int $limit = 0): array;

    public function getElementByClassName($name, int $key = 0): ?ElementInterface;

    public function parseForm(): array;
}
