<?php

namespace webignition\WebResource\Sitemap\Identifier;

use webignition\WebResource\Sitemap\Identifier\Matcher\MatcherInterface;
use webignition\WebResourceInterfaces\SitemapInterface;

/**
 * Identify the type of sitemap by the content of the sitemap
 */
class Identifier
{
    const ATOM_ROOT_NODE_NAME = 'feed';
    const ATOM_ROOT_NAMESPACE_PATTERN = '/http:\/\/www\.w3.org\/2005\/Atom/';

    const RSS_ROOT_NODE_NAME = 'rss';

    const SITEMAPS_ORG_XML_ROOT_NODE_NAME = 'urlset';
    const SITEMAPS_ORG_XML_ROOT_NAMESPACE_PATTERN =
        '/http:\/\/www\.(sitemaps\.org)|(google\.com)\/schemas\/sitemap\/((\d+)|(\d+\.\d+))$/';

    const SITEMAPS_ORG_XML_INDEX_ROOT_NODE_NAME = 'sitemapindex';
    const SITEMAPS_ORG_XML_INDEX_ROOT_NAMESPACE_PATTERN =
        '/http:\/\/www\.(sitemaps\.org)|(google\.com)\/schemas\/sitemap\/((\d+)|(\d+\.\d+))$/';


    /**
     * @var MatcherInterface[]
     */
    private $matchers = [];

    public function __construct()
    {
        $sitemapsOrgXmlMatcher = new Matcher\RootNodeAndNamespaceXmlMatcher(
            self::SITEMAPS_ORG_XML_ROOT_NAMESPACE_PATTERN,
            self::SITEMAPS_ORG_XML_ROOT_NODE_NAME,
            SitemapInterface::TYPE_SITEMAPS_ORG_XML
        );

        $sitemapsOrgTxtMatcher = new Matcher\TextListMatcher(SitemapInterface::TYPE_SITEMAPS_ORG_TXT);

        $rssFeedMatcher = new Matcher\RootNodeXmlMatcher(
            self::RSS_ROOT_NODE_NAME,
            SitemapInterface::TYPE_RSS
        );

        $atomFeedMatcher = new Matcher\RootNodeAndNamespaceXmlMatcher(
            self::ATOM_ROOT_NAMESPACE_PATTERN,
            self::ATOM_ROOT_NODE_NAME,
            SitemapInterface::TYPE_ATOM
        );

        $sitemapsOrgXmlIndexMatcher = new Matcher\RootNodeAndNamespaceXmlMatcher(
            self::SITEMAPS_ORG_XML_INDEX_ROOT_NAMESPACE_PATTERN,
            self::SITEMAPS_ORG_XML_INDEX_ROOT_NODE_NAME,
            SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX
        );

        $this->matchers[] = $sitemapsOrgXmlMatcher;
        $this->matchers[] = $sitemapsOrgTxtMatcher;
        $this->matchers[] = $rssFeedMatcher;
        $this->matchers[] = $atomFeedMatcher;
        $this->matchers[] = $sitemapsOrgXmlIndexMatcher;
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function getType($content)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->matches($content)) {
                return $matcher->getType();
            }
        }

        return null;
    }
}
