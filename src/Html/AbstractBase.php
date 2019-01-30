<?php

namespace duncan3dc\Dom\Html;

/**
 * @property array $childNodes
 */
abstract class AbstractBase extends \duncan3dc\Dom\AbstractBase
{


    protected function newElement($element)
    {
        return new Element($element);
    }


    public function getElementsByClassName($name, int $limit = 0): array
    {
        if (!is_array($name)) {
            $name = [$name];
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
            foreach ($name as $val) {
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


    public function getElementByClassName($name, int $key = 0): ?ElementInterface
    {
        $elements = $this->getElementsByClassName($name, $key + 1);

        return isset($elements[$key]) ? $elements[$key] : null;
    }


    public function parseForm(): array
    {
        $url = $this->generateUrlFromFormElements();

        parse_str($url, $data);

        return $data;
    }


    private function generateUrlFromFormElements(): string
    {
        if (!is_array($this->childNodes)) {
            return "";
        }

        $url = "";

        foreach ($this->childNodes as $node) {

            # Recurse
            if (!in_array($node->nodeName, ["input", "select", "textarea"], true)) {
                $url .= $node->generateUrlFromFormElements();
                continue;
            }

            # Get the element's name, ignore if it doesn't have one
            $name = $node->getAttribute("name");
            if (!$name) {
                continue;
            }

            # Custom handling for the currently selected option, or default the first one
            if ($node->nodeName === "select") {
                $options = $node->getTags("option");

                if (count($options) < 1) {
                    continue;
                }

                $found = false;
                $value = "";
                foreach ($options as $tag) {
                    if ($tag->hasAttribute("selected")) {
                        $found = true;
                        $value = $tag->getAttribute("value");
                        break;
                    }
                }
                if (!$found) {
                    $value = $options[0]->getAttribute("value");
                }

            # Text area's value is just within the opening and closing tags
            } elseif ($node->nodeName === "textarea") {
                $value = $node->nodeValue;

            # For all other elements assume their value attribute contains the relevant value
            } else {
                $value = $node->getAttribute("value");
            }

            # Don't send any checkboxes/radio elements that aren't checked
            if (in_array($node->getAttribute("type"), ["checkbox", "radio"], true)) {
                if (!$node->hasAttribute("checked")) {
                    continue;
                }
            }

            $url .= "&{$name}={$value}";
        }

        return $url;
    }


    /**
     * Serialize this element using pretty formatting.
     *
     * @return string
     */
    public function toString(): string
    {
        if ($this->dom instanceof \DOMDocument) {
            $doc = $this->dom;
        } else {
            $doc = $this->dom->ownerDocument;
        }

        $doc->formatOutput = true;

        return (string) $doc->saveHTML($this->dom);
    }
}
