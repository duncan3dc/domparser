<?php

namespace duncan3dc\DomParser;

class XmlParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    public function __construct()
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
        $this->assertSame(count($this->parser->getTags("child")), 3);
    }
    public function testGetTags2()
    {
        $this->assertSame(count($this->parser->getElementsByTagName("child")), 3);
    }


    public function testGetTag1()
    {
        $this->assertSame($this->parser->getTag("child", 1)->nodeValue, "Child2");
    }
    public function testGetTag2()
    {
        $this->assertSame($this->parser->getElementByTagName("child")->nodeValue, "Child1");
    }


    public function testGetTagsNS1()
    {
        $this->assertSame(count($this->parser->getTagsNS("http://www.w3.org/1999/XSL/Transform", "detail")), 1);
    }
    public function testGetTagsNS2()
    {
        $this->assertSame(count($this->parser->getElementsByTagNameNS("http://www.w3.org/1999/XSL/Transform", "item")), 1);
    }


    public function testGetTagNS1()
    {
        $this->assertSame($this->parser->getTagNS("http://www.w3.org/1999/XSL/Transform", "name")->nodeValue, "NamespacedValue");
    }
    public function testGetTagNS2()
    {
        $this->assertSame($this->parser->getElementByTagNameNS("http://www.w3.org/1999/XSL/Transform", "item")->tagName, "extra:item");
    }


    public function testOutput()
    {
        $this->assertSame($this->parser->getTag("child")->output(), "<child>Child1</child>");
    }
}
