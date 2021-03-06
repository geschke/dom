<?php
/*
 * (c) webfactory GmbH <info@webfactory.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Webfactory\Dom;

class XHTML10ParsingHelper extends HTMLParsingHelper {

    protected function wrapFragment($fragment, $declaredNamespaces)
    {
        return
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'
            . parent::wrapFragment(
                $fragment,
                $declaredNamespaces
            );
    }

    protected function fixDump($dump)
    {
        /*
        * Vgl. http://mail.gnome.org/archives/xml/2011-December/msg00029.html
        * Die libxml2 erkennt XHTML-Dokumente und gibt in diesem Fall nur die in der
        * XHTML-DTD als EMPTY definierten Tags in <kurzer /> Form aus. Alle anderen
        * Tags werden <so></so> ausgegeben, um mit http://www.w3.org/TR/xhtml1/#C_3
        * konform zu gehen. Das LIBXML_EMPTYTAG-Flag in DOMDocument::saveXML spielt
        * dabei keine Rolle.
        *
        * Mit anderen Worten: Wir können <esi:include .../> nicht in der notwendigen
        * Form ausgeben, bis wir nicht mindestens eine gepatch'te Version der libxml2
        * überall einsetzen können/wollen. Da ist das hier doch ein vertretbarer Fix,
        * oder?
        */
        return str_replace('></esi:include>', '/>', $dump);
    }
}
