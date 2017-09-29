<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

use Hobnob\XmlStreamReader\Parser;

class SitemapsOrgXmlIndexUrlExtractor implements UrlExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extract($content)
    {
        $urls = [];

        $xmlParser = new Parser();
        $xmlParser->registerCallback(
            '/sitemapindex/sitemap',
            function (Parser $parser, \SimpleXMLElement $node) use (&$urls) {
                $urls[] = (string)$node;
            }
        );
        $xmlParser->parse($content);

        return $urls;
    }
}
