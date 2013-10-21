<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlIndexUrlExtractor extends UrlExtractor {

    public function extract($content) {
        $urls = array();
        
        $xmlParser = new \Hobnob\XmlStreamReader\Parser();        
        $xmlParser->registerCallback(
            '/sitemapindex/sitemap',
            function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node) use (&$urls) {
                $urls[] = (string)$node;
            }
        );
        $xmlParser->parse($content);       
        
        return $urls;
    }
    
}