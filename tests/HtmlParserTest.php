<?php

namespace duncan3dc\DomParser;

class HtmlParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;

    public function __construct()
    {
        $this->parser = new HtmlParser(<<<HTML
<html>
    <head>
        <title data-stuff='ok'>Test Title</title>
    </head>
    <body>
        <div class='data1 one' data-stuff='ok'>Data1.1</div>
        <div class='data1 two'>Data1.2</div>
        <div class='data1 three' id='data1.3'>Data1.3</div>
    </detail>
</document>
HTML
);
    }


    public function testGetElementById1()
    {
        $this->assertSame("Data1.3", $this->parser->getElementById("data1.3")->nodeValue);
    }
    public function testGetElementById2()
    {
        $this->assertFalse($this->parser->getElementById("data1.4"));
    }


    public function testGetTags1()
    {
        $this->assertSame(3, count($this->parser->getTags("div")));
    }
    public function testGetTags2()
    {
        $this->assertSame(3, count($this->parser->getElementsByTagName("div")));
    }


    public function testGetTag1()
    {
        $this->assertSame("Data1.2", $this->parser->getTag("div", 1)->nodeValue);
    }
    public function testGetTag2()
    {
        $this->assertSame("Test Title", $this->parser->getElementByTagName("title")->nodeValue);
    }
    public function testGetTag3()
    {
        $this->assertFalse($this->parser->getElementByTagName("no-such-tag"));
    }


    public function testGetElementsByClassName1()
    {
        $this->assertSame(3, count($this->parser->getElementsByClassName("data1")));
    }


    public function testGetElementsByClassName2()
    {
        $this->assertSame(1, count($this->parser->getElementsByClassName(["data1", "two"])));
    }


    public function testGetElementByClassName1()
    {
        $this->assertSame("Data1.1", $this->parser->getElementByClassName(["data1", "one"])->nodeValue);
    }


    public function testParentNode()
    {
        $this->assertSame("body", $this->parser->getTag("div")->parentNode->nodeName);
    }


    public function testOutput()
    {
        $parser = new HtmlParser("<h1>Test</h1>");
        $output = $parser->output();
        $lines = explode("\n", $output);
        $this->assertSame("<html><body><h1>Test</h1></body></html>", $lines[1]);
    }


    public function testXpath1()
    {
        $this->assertSame("Test Title", $this->parser->xpath("/html/head/title")[0]->nodeValue);
    }
    public function testXpath2()
    {
        $this->assertSame([], $this->parser->xpath("/title"));
    }
    public function testXpath3()
    {
        $this->assertSame("Test Title", $this->parser->xpath("//title")[0]->nodeValue);
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
        $this->assertSame("text/html; charset=utf-8", $contentType);
    }
}
