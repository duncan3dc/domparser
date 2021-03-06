<?php

namespace duncan3dc\Dom\Xml;

use duncan3dc\Dom\ElementTrait;

/**
 * Represents an xml element.
 */
class Element extends AbstractBase implements ElementInterface
{
    use ElementTrait;

    /** @var \DOMElement */
    protected $dom;
}
