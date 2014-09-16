<?php

namespace Webfactory\Dom;

use Webfactory\Dom\Exception\EmptyXMLStringException;
use Webfactory\Dom\Exception\ParsingException;
use Webfactory\Dom\Exception\ParsingHelperException;


class RawHtmlParsingHelper extends BaseParsingHelper {

    /*
     * Ein XML-Dokument ist "vollständig" im Hinblick auf die Namespaces -
     * alle im Dokument verwendeten Namespaces und ihre Prefixe sind im
     * Dokument deklariert. Diese Methode braucht also keine Namespace-
     * Deklarationen übergeben bekommen und braucht auch nicht auf
     * $this->implicitNamespaces zurückgreifen.
     */
    public function parseDocument($xml) {
        $this->document = $xml;
        return true;
//        return $this->parseSanitizedDocument($this->sanitize($xml));
    }

    public function getDocument()
    {
        return $this->document;

    }


}
