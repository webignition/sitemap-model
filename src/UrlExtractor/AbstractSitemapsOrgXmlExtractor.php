<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

abstract class AbstractSitemapsOrgXmlExtractor implements UrlExtractorInterface
{
    const SITEMAP_XML_NAMESPACE_PREFIX = 'http://www.sitemaps.org/schemas/sitemap/';
    const SITEMAP_XML_NAMESPACE_REFERENCE = 's';

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
        $xml->registerXPathNamespace('s', $this->deriveNamespace($xml));

        $result = $xml->xpath($this->getXpath());

        foreach ($result as $url) {
            $urls[] = (string)$url;
        }

        return $urls;
    }

    private function deriveNamespace(\SimpleXMLElement $xml)
    {
        $namespaces = $xml->getNamespaces();

        foreach ($namespaces as $namespace) {
            if (0 === strpos($namespace, self::SITEMAP_XML_NAMESPACE_PREFIX)) {
                return $namespace;
            }
        }

        return null;
    }
}
