<?php

namespace Webfactory\Dom;

use Webfactory\Dom\BaseParser;

class PolyglotHTML5Parser extends BaseParser {

    protected function wrapFragment($fragmentXml) {
        return '<html xmlns:esi="http://www.edge-delivery.org/esi/1.0" xmlns="'.self::XHTMLNS.'">'
            . $fragmentXml
            . '</html>';
    }

    protected function fixDump($dump) {
        // http://www.w3.org/TR/html-polyglot/#empty-elements
        static $voidElements = array(
            'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img',
            'input', 'keygen', 'link', 'meta', 'param', 'source', 'esi');

        preg_match_all('_<((\w+)[^>]*)/>_', $dump, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            if (!in_array($m[2], $voidElements))
                $dump = str_replace($m[0], "<{$m[1]}></{$m[2]}>", $dump);
        }

        return $dump;
    }

}
