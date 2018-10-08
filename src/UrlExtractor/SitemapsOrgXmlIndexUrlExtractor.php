<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlIndexUrlExtractor extends AbstractSitemapsOrgXmlExtractor
{
    const XPATH = '/%s:sitemapindex/%s:sitemap/%s:loc/text()';

    protected function getXpath(): string
    {
        return sprintf(
            self::XPATH,
            self::SITEMAP_XML_NAMESPACE_REFERENCE,
            self::SITEMAP_XML_NAMESPACE_REFERENCE,
            self::SITEMAP_XML_NAMESPACE_REFERENCE
        );
    }
}
