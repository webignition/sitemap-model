<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlIndexUrlExtractor extends AbstractSitemapsOrgXmlExtractor
{
    const XPATH = '/s:sitemapindex/s:sitemap/s:loc/text()';

    /**
     * {@inheritdoc}
     */
    protected function getXpath()
    {
        return self::XPATH;
    }
}
