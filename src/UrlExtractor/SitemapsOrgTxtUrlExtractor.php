<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgTxtUrlExtractor implements UrlExtractorInterface
{
    public function extract(string $content): array
    {
        $rawUrls = explode("\n", trim($content));
        $urls = [];

        foreach ($rawUrls as $rawUrl) {
            $urls[] = trim($rawUrl);
        }

        return $urls;
    }
}
