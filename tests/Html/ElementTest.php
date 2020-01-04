<?php

namespace duncan3dc\DomTests\Html;

use duncan3dc\Dom\Html\Element;
use Mockery;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
    private $dom;
    private $element;

    public function setUp(): void
    {
        $this->dom = Mockery::mock(\DOMElement::class);
        $this->element = new Element($this->dom);
    }


    public function testHasClass1(): void
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn("test");
        $this->assertTrue($this->element->hasClass("test"));
    }
    public function testHasClass2(): void
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn(null);
        $this->assertFalse($this->element->hasClass("test"));
    }
    public function testHasClass3(): void
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn("one1");
        $this->assertFalse($this->element->hasClass("one"));
    }
    public function testHasClass4(): void
    {
        $this->dom->shouldReceive("getAttribute")->with("class")->andReturn("one two");
        $this->assertTrue($this->element->hasClass("one"));
    }


    public function testRemoveChild1(): void
    {
        $element = clone $this->element;
        $this->dom->shouldReceive("removeChild")->with($element->dom);

        $result = $this->element->removeChild($element);
        $this->assertSame($this->element, $result);
    }
}
