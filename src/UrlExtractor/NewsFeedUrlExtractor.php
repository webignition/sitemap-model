<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

use webignition\NormalisedUrl\NormalisedUrl;

class NewsFeedUrlExtractor implements UrlExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extract($content)
    {
        $urls = [];

        $simplepie = new \SimplePie();
        $simplepie->enable_cache(false);
        $simplepie->raw_data = $content;
        @$simplepie->init();

        $items = $simplepie->get_items();
        foreach ($items as $item) {
             /* @var $item \SimplePie_Item */
            $url = new NormalisedUrl($item->get_permalink());
            if (!in_array((string)$url, $urls)) {
                $urls[] = (string)$url;
            }
        }

        return $urls;
    }
}
