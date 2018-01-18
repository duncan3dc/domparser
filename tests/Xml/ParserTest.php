<?php

namespace duncan3dc\DomTests\Xml;

use duncan3dc\Dom\Xml\Element;
use duncan3dc\Dom\Xml\Parser;
use PHPUnit\Framework\TestCase;

use function trim;

class ParserTest extends TestCase
{
    private $parser;

    public function setUp(): void
    {
        $this->parser = new Parser(<<<XML
<document>
    <header>
        <title>Test Title</title>
        <child>Child1</child>
        <child>Child2</child>
        <child>Child3</child>
    </header>
    <detail>
        <item>
            <name type='nametype'>Value</name>
        </item>
    </detail>
    <extra:detail xmlns:extra="http://www.w3.org/1999/XSL/Transform">
        <extra:item>
            <extra:name type='nametype'>NamespacedValue</extra:name>
        </extra:item>
    </extra:detail>
</document>
XML
        );
    }


    /**
     * Ensure there are no errors with conforming XML.
     */
    public function testGetErrors1(): void
    {
        $this->assertSame([], $this->parser->getErrors());
    }


    /**
     * Ensure we can retrieve the details of an invalid tag.
     */
    public function testGetErrors2(): void
    {
        $parser = new Parser("<yep></nope>");
        $errors = [];
        foreach ($parser->getErrors() as $error) {
            $errors[] = trim($error->message);
        }
        $this->assertSame(["Opening and ending tag mismatch: yep line 1 and nope"], $errors);
    }


    /**
     * Ensure we can extract the internal dom node we are wrapping.
     */
    public function testGetDomNode1(): void
    {
        $result = $this->parser->getDomNode();
        $this->assertInstanceOf(\DOMNode::class, $result);
    }


    public function testGetTags1(): void
    {
        $this->assertSame(3, count($this->parser->getTags("child")));
    }
    public function testGetTags2(): void
    {
        $this->assertSame(3, count($this->parser->getElementsByTagName("child")));
    }


    public function testGetTag1(): void
    {
        $this->assertSame("Child2", $this->parser->getTag("child", 1)->nodeValue);
    }
    public function testGetTag2(): void
    {
        $this->assertSame("Child1", $this->parser->getElementByTagName("child")->nodeValue);
    }


    public function testGetTagsNS1(): void
    {
        $this->assertSame(1, count($this->parser->getTagsNS("http://www.w3.org/1999/XSL/Transform", "detail")));
    }
    public function testGetTagsNS2(): void
    {
        $this->assertSame(1, count($this->parser->getElementsByTagNameNS("http://www.w3.org/1999/XSL/Transform", "item")));
    }


    public function testGetTagNS1(): void
    {
        $this->assertSame("NamespacedValue", $this->parser->getTagNS("http://www.w3.org/1999/XSL/Transform", "name")->nodeValue);
    }
    public function testGetTagNS2(): void
    {
        $this->assertSame("extra:item", $this->parser->getElementByTagNameNS("http://www.w3.org/1999/XSL/Transform", "item")->tagName);
    }
    public function testGetTagNS3(): void
    {
        $this->assertNull($this->parser->getElementByTagNameNS("http://www.w3.org/1999/XSL/Transform", "no-such-element"));
    }


    public function testParentNode(): void
    {
        $this->assertSame("header", $this->parser->getTag("title")->parentNode->nodeName);
    }


    public function testChildNodes(): void
    {
        $this->assertContainsOnlyInstancesOf(Element::class, $this->parser->getTag("title")->childNodes);
    }


    public function testNodeValue(): void
    {
        $this->assertSame("modified", $this->parser->getTag("title")->nodeValue("modified")->nodeValue);
    }


    /**
     * Ensure we can convert a single tag to a string.
     */
    public function testToString1(): void
    {
        $this->assertSame("<child>Child1</child>", $this->parser->getTag("child")->toString());
    }


    /**
     * Ensure we can convert an entire document to a string.
     */
    public function testToString2(): void
    {
        $parser = new Parser("<parent><child>One</child></parent>");
        $this->assertSame('<?xml version="1.0" encoding="UTF-8"?>' . "\n<parent>\n  <child>One</child>\n</parent>\n", $parser->toString());
    }


    public function testHasAttribute(): void
    {
        $this->assertFalse($this->parser->getTag("name")->hasAttribute("nope"));
        $this->assertTrue($this->parser->getTag("name")->hasAttribute("type"));
    }


    public function testGetAttribute(): void
    {
        $this->assertSame("nametype", $this->parser->getTag("name")->getAttribute("type"));
    }


    public function testSetAttribute(): void
    {
        $this->assertSame("new-attribute", $this->parser->getTag("title")->setAttribute("test", "new-attribute")->getAttribute("test"));
    }


    public function testGetAttributes(): void
    {
        $attributes = $this->parser->getTag("title")
            ->setAttribute("test", "new-attribute")
            ->setAttribute("test2", "extra")
            ->getAttributes();
        $this->assertSame([
            "test"  =>  "new-attribute",
            "test2" =>  "extra",
        ], $attributes);
    }


    /**
     * Ensure we can convert an element object to a string
     */
    public function testCastToString1(): void
    {
        $this->assertSame("Test Title", (string) $this->parser->getTag("title"));
    }
}
