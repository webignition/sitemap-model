<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

interface UrlExtractorInterface
{
    public function extract(string $content): array;
}
