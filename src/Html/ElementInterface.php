<?php

namespace duncan3dc\Dom\Html;

/**
 * @extends \duncan3dc\Dom\ElementInterface<\duncan3dc\Dom\Html\ElementInterface>
 */
interface ElementInterface extends \duncan3dc\Dom\ElementInterface, HtmlInterface
{
    public function hasClass(string $name): bool;
}
