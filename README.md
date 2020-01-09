domparser
=========

Wrappers for the PHP DOMDocument class to provide extra functionality for html/xml parsing

[![release](https://poser.pugx.org/duncan3dc/domparser/version.svg)](https://packagist.org/packages/duncan3dc/domparser)
[![build](https://github.com/duncan3dc/domparser/workflows/.github/workflows/buildcheck.yml/badge.svg?branch=master)](https://github.com/duncan3dc/domparser/actions?query=branch%3Amaster+workflow%3A.github%2Fworkflows%2Fbuildcheck.yml)
[![coverage](https://codecov.io/gh/duncan3dc/domparser/graph/badge.svg)](https://codecov.io/gh/duncan3dc/domparser)


Constructor Arguments
---------------------
There are 2 constructors available, one for the HtmlParser class and one for the XmlParser class, they both work in the same way.
* Only 1 parameter is available, which should be passed as a string, and contain the content to parse (xml/html)
* Warnings are captured during the loading of the content using libxml_use_internal_errors() and libxml_get_errors(), these are available from the errors property after the class has been initiated


Public Properties
-----------------
* html/xml (string) - Depending on which class was used one of these properties will be present and contain the content used for parsing
* errors (array) - If any errors were encountered during parsing they will be in this array (see [Constructor Arguments])
* dom (DOMDocument) - This is the internal instance of the DOMDocument class used
* mode (string) - Indicates whether the parser is operating in html or xml mode


Public Methods
--------------
* getTags(string $tagName): array - Similar to DOMDocument::getElementsByTagName() except a standard array is returned.  
Alias: getElementsByTagName()
* getTag(string $tagName): Element - Similar to getTags() but will return the first element matched, instead of an array of elements.  
Alias: getElementByTagName()
* getElementsByClassName(mixed $className): array - Matches elements that have a class attribute that matches the string parameter.  
If you want to find elements with multiple classes, pass the $className as an array of classes, and only elements that have all classes will be returned
* getElementByClassName(mixed $className): Element - Similar to getElementsByClassName() except this will return the first element matched
* output(): string - Returns the xml/html repesented by the receiver, formatted using DOMDocument::formatOutput
* xpath(string $path): array - Returns an array of elements matching the $path


Dom Elements
------------
All of the methods that return elements return them as instances of the Element class, this acts similarly to the standard DOMElement class, except it has all of the above methods available, and the nodeValue property has leading and trailing whitespace removed using trim()


Examples
--------

The parser classes use a namespace of duncan3dc\DomParser
```php
use duncan3dc\DomParser\HtmlParser;
use duncan3dc\DomParser\XmlParser;
```

-------------------

```php
$parser = new HtmlParser(file_get_contents("http://example.com"));

echo "Page Title: " . $parser->getTag("title")->nodeValue . "\n";

$contentType = false;
$meta = $parser->getTags("meta");
foreach($meta as $element) {
	if($element->getAttribute("http-equiv") == "Content-type") {
		$contentType = $element->getAttribute("content");
	}
}
echo "Content Type: " . (($contentType) ?: "NOT FOUND") . "\n";
```


## duncan3dc/domparser for enterprise

Available as part of the Tidelift Subscription

The maintainers of duncan3dc/domparser and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source dependencies you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact dependencies you use. [Learn more.](https://tidelift.com/subscription/pkg/packagist-duncan3dc-domparser?utm_source=packagist-duncan3dc-domparser&utm_medium=referral&utm_campaign=readme)
