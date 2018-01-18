<?php

namespace duncan3dc\Dom;

/**
 * Shared methods for the parsers.
 */
trait ParserTrait
{
    /**
     * @inheritdoc
     */
    public function xpath(string $path): array
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
