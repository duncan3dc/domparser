<?php

namespace duncan3dc\DomParser;

class HtmlBase extends Base
{
    public function __construct($dom)
    {
        parent::__construct($dom, "html");
    }


    protected function newElement($element)
    {
        return new HtmlElement($element);
    }


    public function getElementById($id)
    {
        if (!$element = $this->dom->getElementById($id)) {
            return false;
        }

        return $this->newElement($element);
    }


    public function getElementsByClassName($className, $limit = 0)
    {
        if (!is_array($className)) {
            $className = [$className];
        }

        $return = [];

        $elements = $this->dom->getElementsByTagName("*");
        foreach ($elements as $node) {
            if (!$node->hasAttributes()) {
                continue;
            }

            if (!$check = $node->attributes->getNamedItem("class")) {
                continue;
            }

            $classes = explode(" ", $check->nodeValue);
            $found = true;
            foreach ($className as $val) {
                if (!in_array($val, $classes)) {
                    $found = false;
                    break;
                }
            }
            if ($found) {
                $return[] = $this->newElement($node);
                if ($limit) {
                    if (!--$limit) {
                        break;
                    }
                }
            }
        }

        return $return;
    }


    public function getElementByClassName($className, $key = 0)
    {
        $elements = $this->getElementsByClassName($className, $key + 1);

        return isset($elements[$key]) ? $elements[$key] : null;
    }
}
