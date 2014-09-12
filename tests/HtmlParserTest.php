<?php

namespace duncan3dc\DomParser;

class HtmlParserTest extends \PHPUnit_Framework_TestCase
{
    private $parser;

    public function __construct()
    {
        $this->parser = new HtmlParser(<<<HTML
<html>
    <head>
        <title>Test Title</title>
    </head>
    <body>
        <div class='data1 one'>Data1.1</div>
        <div class='data1 two'>Data1.2</div>
        <div class='data1 three' id='data1.3'>Data1.3</div>
    </detail>
</document>
HTML
);
    }


    public function testGetElementById()
    {
        $this->assertSame($this->parser->getElementById("data1.3")->nodeValue, "Data1.3");
    }


    public function testGetTags1()
    {
        $this->assertSame(count($this->parser->getTags("div")), 3);
    }
    public function testGetTags2()
    {
        $this->assertSame(count($this->parser->getElementsByTagName("div")), 3);
    }


    public function testGetTag1()
    {
        $this->assertSame($this->parser->getTag("div", 1)->nodeValue, "Data1.2");
    }
    public function testGetTag2()
    {
        $this->assertSame($this->parser->getElementByTagName("title")->nodeValue, "Test Title");
    }


    public function testGetElementsByClassName1()
    {
        $this->assertSame(count($this->parser->getElementsByClassName("data1")), 3);
    }


    public function testGetElementsByClassName2()
    {
        $this->assertSame(count($this->parser->getElementsByClassName(["data1", "two"])), 1);
    }


    public function testGetElementByClassName1()
    {
        $this->assertSame($this->parser->getElementByClassName(["data1", "one"])->nodeValue, "Data1.1");
    }


    public function testParentNode()
    {
        $this->assertSame($this->parser->getTag("div")->parentNode->nodeName, "body");
    }


    public function testRemoteDownload()
    {
        $parser = new HtmlParser("http://example.com");

        $this->assertSame($parser->getTag("title")->nodeValue, "Example Domain");

        $contentType = null;
        $meta = $parser->getTags("meta");
        foreach ($meta as $element) {
            if ($element->getAttribute("http-equiv") == "Content-type") {
                $contentType = $element->getAttribute("content");
            }
        }
        $this->assertSame($contentType, "text/html; charset=utf-8");
    }
}
