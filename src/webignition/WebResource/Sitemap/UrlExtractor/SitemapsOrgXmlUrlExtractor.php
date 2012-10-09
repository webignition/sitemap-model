<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlUrlExtractor extends UrlExtractor {

    public function extract($content) {
        $urls = array();
        $queryPath = new \QueryPath();
        
        try {
            $queryPath->withXML($content, 'url loc')->each(function ($index, \DOMElement $domElement) use (&$urls) {
                if ($domElement->nodeName == 'loc') {
                    $urls[] = \trim($domElement->nodeValue);
                }                
            });            
        } catch (QueryPath\ParseException $parseException) {
            // Invalid XML
        }
        
        return $urls;
    }
    
}