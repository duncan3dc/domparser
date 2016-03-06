<?php

namespace duncan3dc\DomParserTests;

use duncan3dc\DomParser\HtmlElement;
use Mockery;

class HtmlElementTest extends \PHPUnit_Framework_TestCase
{
    protected $dom;
    protected $element;

    public function setUp()
    {
        $this->dom = Mockery::mock(\DOMElement::class);
        $this->element = new HtmlElement($this->dom);
    }


    public function testHasClass1()
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn("test");
        $this->assertTrue($this->element->hasClass("test"));
    }
    public function testHasClass2()
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn(null);
        $this->assertFalse($this->element->hasClass("test"));
    }
    public function testHasClass3()
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn("one1");
        $this->assertFalse($this->element->hasClass("one"));
    }
    public function testHasClass4()
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn("one two");
        $this->assertTrue($this->element->hasClass("one"));
    }
}
