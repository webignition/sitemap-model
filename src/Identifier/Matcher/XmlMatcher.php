<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

abstract class XmlMatcher extends Matcher
{
    /**
     * @var \DOMDocument
     */
    private $domDocument = null;

    /**
     * @var bool
     */
    private $isParseableXml = null;

    public function matches(?string $content = null): bool
    {
        if (trim($content) == '') {
            return false;
        }

        libxml_use_internal_errors(true);

        $this->domDocument = new \DOMDocument();
        $this->isParseableXml = $this->domDocument->loadXML($content);

        libxml_use_internal_errors(false);

        return $this->isParseableXml();
    }

    public function isParseableXml(): bool
    {
        return $this->isParseableXml;
    }

    protected function getDomDocument(): \DOMDocument
    {
        return $this->domDocument;
    }
}
