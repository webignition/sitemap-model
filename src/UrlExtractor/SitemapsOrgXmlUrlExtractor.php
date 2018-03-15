<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlUrlExtractor extends AbstractSitemapsOrgXmlExtractor
{
    const XPATH = '/%s:urlset/%s:url/%s:loc/text()';

    /**
     * {@inheritdoc}
     */
    protected function getXpath()
    {
        return sprintf(
            self::XPATH,
            self::SITEMAP_XML_NAMESPACE_REFERENCE,
            self::SITEMAP_XML_NAMESPACE_REFERENCE,
            self::SITEMAP_XML_NAMESPACE_REFERENCE
        );
    }
}
