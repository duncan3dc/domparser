<?php

namespace duncan3dc\Dom\Html;

use duncan3dc\Dom\ElementTrait;

/**
 * Represents an html element.
 */
class Element extends AbstractBase implements ElementInterface
{
    use ElementTrait;

    /** @var \DOMElement */
    protected $dom;


    /**
     * Check if this element has the specified class applied to it.
     *
     * @param string $name The name of the class to check for (case-sensitive)
     *
     * @return bool
     */
    public function hasClass(string $name): bool
    {
        if (!$class = $this->dom->getAttribute("class")) {
            return false;
        }

        $classes = explode(" ", $class);

        return in_array($name, $classes, true);
    }
}
