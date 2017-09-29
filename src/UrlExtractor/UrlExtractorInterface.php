<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

interface UrlExtractorInterface
{
    /**
     * @param string $content
     *
     * @return string[]
     */
    public function extract($content);
}
