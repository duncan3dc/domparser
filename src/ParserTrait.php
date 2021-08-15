<?php

namespace duncan3dc\Dom;

use function assert;

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
        assert($list instanceof \DOMNodeList);

        $return = [];
        foreach ($list as $node) {
            $return[] = $this->newElement($node);
        }

        return $return;
    }
}
