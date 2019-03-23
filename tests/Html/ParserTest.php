<?php

namespace duncan3dc\DomTests\Html;

use duncan3dc\Dom\Html\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    private $parser;

    public function setUp(): void
    {
        $this->parser = new Parser(<<<HTML
<html>
    <head>
        <title data-stuff='ok'>Test Title</title>
    </head>
    <body>
        <div class='data1 one' data-stuff='ok'>Data1.1</div>
        <div class='data1 two'>Data1.2</div>
        <div class='data1 three' id='data1.3'>Data1.3</div>
        <form id='form1'>
            <input name='test' value='ok'>

            <input name='bag[]' value='one'>
            <formset>
                <input name='bag[]' value='two'>
            </formset>
            <input name='data[item][level]' value='nested'>

            <input name='filtered' type='checkbox' value='yep' checked>
            <input name='validated' type='checkbox' value='yep'>

            <select name='option1'>
                <option value='value1'>Value 1</option>
                <option value='value2'>Value 2</option>
            </select>

            <select name='option2'>
                <option value='value1'>Value 1</option>
                <option value='value2' selected>Value 2</option>
            </select>

            <textarea name='comments'>blah blah blah</textarea>
    </body>
</html>
HTML
        );
    }


    public function testGetElementById1(): void
    {
        $this->assertSame("Data1.3", $this->parser->getElementById("data1.3")->nodeValue);
    }
    public function testGetElementById2(): void
    {
        $this->assertFalse($this->parser->getElementById("data1.4"));
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
        $this->assertSame(3, count($this->parser->getTags("div")));
    }
    public function testGetTags2(): void
    {
        $this->assertSame(3, count($this->parser->getElementsByTagName("div")));
    }


    public function testGetTag1(): void
    {
        $this->assertSame("Data1.2", $this->parser->getTag("div", 1)->nodeValue);
    }
    public function testGetTag2(): void
    {
        $this->assertSame("Test Title", $this->parser->getElementByTagName("title")->nodeValue);
    }
    public function testGetTag3(): void
    {
        $this->assertFalse($this->parser->getElementByTagName("no-such-tag"));
    }


    public function testGetElementsByClassName1(): void
    {
        $this->assertSame(3, count($this->parser->getElementsByClassName("data1")));
    }


    public function testGetElementsByClassName2(): void
    {
        $this->assertSame(1, count($this->parser->getElementsByClassName(["data1", "two"])));
    }


    public function testGetElementByClassName1(): void
    {
        $this->assertSame("Data1.1", $this->parser->getElementByClassName(["data1", "one"])->nodeValue);
    }


    public function testParentNode(): void
    {
        $this->assertSame("body", $this->parser->getTag("div")->parentNode->nodeName);
    }


    public function testOutput(): void
    {
        $parser = new Parser("<h1>Test</h1>");
        $output = $parser->output();
        $lines = explode("\n", $output);
        $this->assertSame("<html><body><h1>Test</h1></body></html>", $lines[1]);
    }


    public function testXpath1(): void
    {
        $this->assertSame("Test Title", $this->parser->xpath("/html/head/title")[0]->nodeValue);
    }
    public function testXpath2(): void
    {
        $this->assertSame([], $this->parser->xpath("/title"));
    }
    public function testXpath3(): void
    {
        $this->assertSame("Test Title", $this->parser->xpath("//title")[0]->nodeValue);
    }


    public function testParseForm(): void
    {
        $data = $this->parser->getElementById("form1")->parseForm();
        $this->assertSame([
            "test"      =>  "ok",
            "bag"       =>  ["one", "two"],
            "data"      =>  ["item" => ["level" => "nested"]],
            "filtered"  =>  "yep",
            "option1"   =>  "value1",
            "option2"   =>  "value2",
            "comments"  =>  "blah blah blah",
        ], $data);
    }
}
