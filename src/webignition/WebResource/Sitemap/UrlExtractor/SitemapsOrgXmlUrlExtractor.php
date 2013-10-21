<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlUrlExtractor extends UrlExtractor {

    public function extract($content) {        
        $urls = array();
        
        $xmlParser = new \Hobnob\XmlStreamReader\Parser();        
        $xmlParser->registerCallback(
            '/urlset/url',
            function( \Hobnob\XmlStreamReader\Parser $parser, \SimpleXMLElement $node) use (&$urls) {
                $urls[] = (string)$node;
            }
        );
        $xmlParser->parse($content);       
        
        return $urls;
    }

}