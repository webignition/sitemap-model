<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlIndexUrlExtractor extends UrlExtractor {

    public function extract($content) {
        $urls = array();
        $queryPath = new \QueryPath();
        
        try {
            $queryPath->withXML($content, 'sitemap loc')->each(function ($index, \DOMElement $domElement) use (&$urls) {
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