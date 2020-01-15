Changelog
=========

## x.y.z - UNRELEASED

--------

## 2.0.2 - 2020-01-15

### Fixed

* [Interfaces] Html\Parser should implement Html\ParserInterface
* [Interfaces] Xml\Parser should implement Xml\ParserInterface

--------

## 2.0.1 - 2020-01-09

### Fixed

* [Interfaces] Added `__toString()` to the `ElementInterface`

--------

## 2.0.0 - 2020-01-09

### Added

* [Support] Added support for PHP 7.2, 7.3, and 7.4.
* [Support] Dropped support for PHP 5.6, 7.0, and 7.1.
* [Interfaces] All classes now implement interfaces to allow extension/customisation.

### Changed

* All classes are now in the `\duncan3dc\Dom` namespace.  
  The existing `\duncan3dc\DomParser` namespace remaings for backwords compatibility.
* [HTML/XML] The `output()` method has been repalced by `toString()`.
* [HTML/XML] The public `dom` property has been replaced by a `getDomNode()` method.
* [HTML/XML] The public `errors` property has been replaced by a `getErrors()` method.

### Fixed

* [HTML] Prevent `getElementById()` from being called on an element.
* [HTML/XML] Prevent `xpath()` from being called on an element.

### Removed

* [HTML/XML] Removed the downloading feature (eg `new HtmlParser("http://example.com")`).  
  The constructor now requires a string containing XML or HTML.
