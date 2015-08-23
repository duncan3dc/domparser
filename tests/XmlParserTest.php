<?php

namespace duncan3dc\DomParserTests;

use duncan3dc\DomParser\XmlParser;

class XmlParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    public function setUp()
    {
        $this->parser = new XmlParser(<<<XML
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


    public function testGetTags1()
    {
        $this->assertSame(3, count($this->parser->getTags("child")));
    }
    public function testGetTags2()
    {
        $this->assertSame(3, count($this->parser->getElementsByTagName("child")));
    }


    public function testGetTag1()
    {
        $this->assertSame("Child2", $this->parser->getTag("child", 1)->nodeValue);
    }
    public function testGetTag2()
    {
        $this->assertSame("Child1", $this->parser->getElementByTagName("child")->nodeValue);
    }


    public function testGetTagsNS1()
    {
        $this->assertSame(1, count($this->parser->getTagsNS("http://www.w3.org/1999/XSL/Transform", "detail")));
    }
    public function testGetTagsNS2()
    {
        $this->assertSame(1, count($this->parser->getElementsByTagNameNS("http://www.w3.org/1999/XSL/Transform", "item")));
    }


    public function testGetTagNS1()
    {
        $this->assertSame("NamespacedValue", $this->parser->getTagNS("http://www.w3.org/1999/XSL/Transform", "name")->nodeValue);
    }
    public function testGetTagNS2()
    {
        $this->assertSame("extra:item", $this->parser->getElementByTagNameNS("http://www.w3.org/1999/XSL/Transform", "item")->tagName);
    }
    public function testGetTagNS3()
    {
        $this->assertFalse($this->parser->getElementByTagNameNS("http://www.w3.org/1999/XSL/Transform", "no-such-element"));
    }


    public function testParentNode()
    {
        $this->assertSame("header", $this->parser->getTag("title")->parentNode->nodeName);
    }


    public function testChildNodes()
    {
        $this->assertContainsOnlyInstancesOf("\duncan3dc\DomParser\XmlElement", $this->parser->getTag("title")->childNodes);
    }


    public function testNodeValue()
    {
        $this->assertSame("modified", $this->parser->getTag("title")->nodeValue("modified")->nodeValue);
    }


    public function testOutput()
    {
        $this->assertSame("<child>Child1</child>", $this->parser->getTag("child")->output());
    }


    public function testSetAttribute()
    {
        $this->assertSame("new-attribute", $this->parser->getTag("title")->setAttribute("test", "new-attribute")->getAttribute("test"));
    }


    public function testGetAttributes()
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


    public function testToString()
    {
        $this->assertSame("Test Title", (string) $this->parser->getTag("title"));
    }
}
