<?php
namespace Webfactory\Dom\Test;

class XHTML10ParsingHelperTest extends HTMLParsingHelperTest {

    protected function createParsingHelper() {
        return new \Webfactory\Dom\XHTML10ParsingHelper();
    }

    public function testEntireDocumentIsPreserved() {
        $entireDocument = <<<XML
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head>
    <body>
        <blah:test xmlns:blah="urn:foo">xx</blah:test>
        <p class="nonamespace">xx</p>
        <p xmlns:foo="urn:test" class="foonamespace">
            <div>
                <foo:bar>xx</foo:bar>
            </div>
        </p>
        <div class="transplant"><p>foo</p><p>foo</p></div>
        <div xmlns:fb="urn:fakebug" class="transplant-2"><fb:p>foo</fb:p><fb:p>foo</fb:p></div>
    </body>
</html>
XML;
        $document = $this->parser->parseDocument($entireDocument);
        $this->assertXmlStringEqualsXmlString($entireDocument, $this->parser->dump($document));
    }

    public function testIncompleteDocumentIsFixed() {
        $missingNSDecl = <<<XML
<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <body>
        <p>Foo</p>
    </body>
</html>
XML;

        $fixedNsDecl = str_replace('<html>', '<html xmlns="http://www.w3.org/1999/xhtml">', $missingNSDecl);

        $document = $this->parser->parseDocument($missingNSDecl);
        $this->assertEquals($fixedNsDecl, trim($this->parser->dump($document)));
    }

    public function testVoidTagsArePreservedWhileEmptyTagsAreExpanded() {
        $this->readDumpAssertFragment(
            '<area/><base/><br/><col/><hr/><img/><input/><link/><meta/><param/>',
            '<area shape="rect" /><base /><br /><col span="1" /><hr /><img /><input type="text" /><link /><meta /><param valuetype="data" />'
        );

        $this->readDumpAssertFragment('<p/>', '<p></p>');
    }

}
