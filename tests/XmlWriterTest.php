<?php

namespace duncan3dc\DomTests;

use duncan3dc\Dom\XmlWriter;
use PHPUnit\Framework\TestCase;

class XmlWriterTest extends TestCase
{
    private function checkXml($xml, $check)
    {
        $this->assertSame("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" . $check, $xml);
    }

    public function testCreateXmlSimple()
    {
        $xml = XmlWriter::createXml([
            "simple" => "ok",
        ]);

        $this->checkXml($xml, <<<XML
<simple>ok</simple>
XML
);
    }


    public function testCreateXmlNested()
    {
        $xml = XmlWriter::createXml([
            "nested1" => [
                "nested2"   =>  [
                    "nested3"   =>  "ok",
                ],
            ],
        ]);

        $this->checkXml($xml, <<<XML
<nested1><nested2><nested3>ok</nested3></nested2></nested1>
XML
);
    }


    public function testCreateXmlMultipleNames()
    {
        $xml = XmlWriter::createXml([
            "samename_1" => "ok",
            "samename_2" => "ok",
            "samename_3" => "ok",
        ]);

        $this->checkXml($xml, <<<XML
<samename>ok</samename>
<samename>ok</samename>
<samename>ok</samename>
XML
);
    }


    public function testCreateXmlAttributes()
    {
        $xml = XmlWriter::createXml([
            "attributes" => [
                "_attributes"   =>  [
                    "one"   =>  1,
                    "two"   =>  2,
                ],
            ],
        ]);

        $this->checkXml($xml, <<<XML
<attributes one="1" two="2"/>
XML
);
    }


    public function testCreateXmlValue()
    {
        $xml = XmlWriter::createXml([
            "attributes" => [
                "_attributes"   =>  [
                    "one"   =>  1,
                    "two"   =>  2,
                ],
                "_value"        =>  "MY_VALUE",
            ],
        ]);

        $this->checkXml($xml, <<<XML
<attributes one="1" two="2">MY_VALUE</attributes>
XML
);
    }


    public function testCreateXml1()
    {
        $xml = XmlWriter::createXml([
            "tag_1" =>  [
                "tag1a" =>  "ok",
                "tag1b" =>  "ok",
            ],
            "tag_2" =>  [
                "_attributes"   =>  [
                    "attr"  =>  "ok",
                    "test"  =>  "one",
                ],
                "tag2a" =>  "ok",
                "tag2b" =>  "ok",
            ],
        ]);

        $this->checkXml($xml, <<<XML
<tag><tag1a>ok</tag1a><tag1b>ok</tag1b></tag>
<tag attr="ok" test="one"><tag2a>ok</tag2a><tag2b>ok</tag2b></tag>
XML
);
    }


    public function testGetDomDocument()
    {
        $xml = new XmlWriter([]);
        $this->assertInstanceOf("DOMDocument", $xml->getDomDocument());
    }


    public function testFormat()
    {
        $xml = XmlWriter::formatXml([
            "parent" =>  [
                "child1"    =>  "ok",
                "child2"    =>  "ok",
            ],
        ]);

        $this->checkXml($xml, <<<XML
<parent>
  <child1>ok</child1>
  <child2>ok</child2>
</parent>
XML
);
    }


    public function testOverrideEncoding1()
    {
        $xml = new XmlWriter([], "iso-8859-1");

        $this->assertSame("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n", $xml->toString());
    }
    public function testOverrideEncoding2()
    {
        $xml = XmlWriter::createXml([], "iso-8859-1");

        $this->assertSame("<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>", $xml);
    }
}
