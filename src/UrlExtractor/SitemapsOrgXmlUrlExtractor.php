<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

class SitemapsOrgXmlUrlExtractor implements UrlExtractorInterface
{
    const SITEMAP_XML_NAMESPACE = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /**
     * {@inheritdoc}
     */
    public function extract($content)
    {
        $urls = [];

        $xml = new \SimpleXMLElement($content);
        $xml->registerXPathNamespace('s', self::SITEMAP_XML_NAMESPACE);

        $result = $xml->xpath('/s:urlset/s:url/s:loc/text()');

        foreach ($result as $url) {
            $urls[] = (string)$url;
        }

        return $urls;
    }
}
