<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

abstract class AbstractSitemapsOrgXmlExtractor implements UrlExtractorInterface
{
    const SITEMAP_XML_NAMESPACE_REFERENCE = 's';

    abstract protected function getXpath(): string;

    public function extract(string $content): array
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
            if (preg_match('/\/schemas\/sitemap\/[0-9\.]+$/', $namespace) > 0) {
                return $namespace;
            }
        }

        return null;
    }
}
