<?php

namespace duncan3dc\Dom\Html;

/**
 * @extends \duncan3dc\Dom\ParserInterface<\duncan3dc\Dom\Html\ElementInterface>
 */
interface ParserInterface extends \duncan3dc\Dom\ParserInterface, HtmlInterface
{
    public function getElementById(string $id): ?ElementInterface;
}
