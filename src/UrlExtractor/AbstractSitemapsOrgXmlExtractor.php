<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

abstract class AbstractSitemapsOrgXmlExtractor implements UrlExtractorInterface
{
    const SITEMAP_XML_NAMESPACE = 'http://www.sitemaps.org/schemas/sitemap/0.9';

    /**
     * @return string
     */
    abstract protected function getXpath();

    /**
     * {@inheritdoc}
     */
    public function extract($content)
    {
        $urls = [];

        $xml = new \SimpleXMLElement($content);
        $xml->registerXPathNamespace('s', self::SITEMAP_XML_NAMESPACE);

        $result = $xml->xpath($this->getXpath());

        foreach ($result as $url) {
            $urls[] = (string)$url;
        }

        return $urls;
    }
}
