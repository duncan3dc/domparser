<?php

namespace duncan3dc\DomTests\Html;

use duncan3dc\Dom\Html\Parser;
use PHPUnit\Framework\TestCase;

use function trim;

class ParserTest extends TestCase
{
    /** @var Parser */
    private $parser;

    protected function setUp(): void
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
            <fieldset>
                <input name='bag[]' value='two'>
            </fieldset>
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


    /**
     * Ensure there are no errors with conforming HTML.
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
        $parser = new Parser("<nope>No</nope>");
        $errors = [];
        foreach ($parser->getErrors() as $error) {
            $errors[] = trim($error->message);
        }
        $this->assertSame(["Tag nope invalid"], $errors);
    }


    public function testGetElementById1(): void
    {
        $this->assertSame("Data1.3", $this->parser->getElementById("data1.3")->nodeValue);
    }
    public function testGetElementById2(): void
    {
        $this->assertNull($this->parser->getElementById("data1.4"));
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
        $this->assertNull($this->parser->getElementByTagName("no-such-tag"));
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


    /**
     * Ensure we can convert a single tag to a string.
     */
    public function testToString1(): void
    {
        $this->assertSame('<div class="data1 three" id="data1.3">Data1.3</div>', $this->parser->getElementById("data1.3")->toString());
    }


    /**
     * Ensure we can convert an entire document to a string.
     */
    public function testToString2(): void
    {
        $parser = new Parser("<h1>Test</h1>");
        $html = $parser->toString();
        $lines = explode("\n", $html);
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


    /**
     * Ensure we can convert an element object to a string
     */
    public function testCastToString1(): void
    {
        $this->assertSame("Test Title", (string) $this->parser->getTag("title"));
    }
}
