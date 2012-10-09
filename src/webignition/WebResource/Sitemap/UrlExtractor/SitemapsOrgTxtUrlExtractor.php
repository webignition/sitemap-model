<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgTxtUrlExtractor extends UrlExtractor {

    public function extract($content) {
        $rawUrls = explode("\n", $content);
        $urls = array();
        
        foreach ($rawUrls as $rawUrl) {
            $urls[] = trim($rawUrl);
        }
        
        return $urls;        
    }
    
}