<?php

namespace duncan3dc\Dom\Html;

interface ElementInterface extends \duncan3dc\Dom\ElementInterface, HtmlInterface
{
    public function hasClass(string $name): bool;
}
