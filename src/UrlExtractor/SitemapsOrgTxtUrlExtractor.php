<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgTxtUrlExtractor implements UrlExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extract($content)
    {
        $rawUrls = explode("\n", $content);
        $urls = [];

        foreach ($rawUrls as $rawUrl) {
            $urls[] = trim($rawUrl);
        }

        return $urls;
    }
}
