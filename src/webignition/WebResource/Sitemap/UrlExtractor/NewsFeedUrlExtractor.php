<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class NewsFeedUrlExtractor extends UrlExtractor {

    public function extract($content) {
        $urls = array();
        
        $simplepie = new \SimplePie();
        $simplepie->enable_cache(false);      
        $simplepie->raw_data = $content;        
        @$simplepie->init();
        
        $items = $simplepie->get_items();        
        foreach ($items as $item) {
             /* @var $item \SimplePie_Item */
            $url = new \webignition\NormalisedUrl\NormalisedUrl($item->get_permalink());
            if (!in_array((string)$url, $urls)) {
                $urls[] = (string)$url;
            }
        }
        
        return $urls;
    }
    
}