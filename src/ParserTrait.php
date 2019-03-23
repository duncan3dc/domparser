<?php

namespace duncan3dc\Dom;

/**
 * Shared methods for the parsers.
 */
trait ParserTrait
{
    /**
     * Get elements using an xpath selector.
     *
     * @param string $path The xpath selector
     *
     * @return Element[]
     */
    public function xpath($path)
    {
        $xpath = new \DOMXPath($this->dom);

        $list = $xpath->query($path);

        $return = [];
        foreach ($list as $node) {
            $return[] = $this->newElement($node);
        }

        return $return;
    }
}
