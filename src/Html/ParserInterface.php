<?php

namespace duncan3dc\Dom\Html;

interface ParserInterface extends \duncan3dc\Dom\ParserInterface, HtmlInterface
{
    public function getElementById(string $id): ?ElementInterface;
}
