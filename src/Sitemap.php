<?php
namespace webignition\WebResource\Sitemap;

use webignition\WebResource\Sitemap\Identifier\Matcher\AtomFeed;
use webignition\WebResource\Sitemap\Identifier\Matcher\RssFeed;
use webignition\WebResource\Sitemap\Identifier\Matcher\SitemapsOrgTxt;
use webignition\WebResource\Sitemap\Identifier\Matcher\SitemapsOrgXml;
use webignition\WebResource\Sitemap\Identifier\Matcher\SitemapsOrgXmlIndex;
use webignition\WebResource\Sitemap\UrlExtractor\UrlExtractorInterface;
use webignition\WebResource\WebResource;
use webignition\WebResource\Sitemap\Identifier\Identifier;
use webignition\WebResource\Sitemap\Configuration as SitemapConfiguration;
use webignition\NormalisedUrl\NormalisedUrl;

class Sitemap extends WebResource
{
    const SITEMAP_INDEX_TYPE = 'sitemaps.org.xml.index';

    /**
     * @var string
     */
    private $type = null;

    /**
     * @var Identifier
     */
    private $identifier = null;

    /**
     * @var Configuration
     */
    private $configuration = null;

    /**
     * Child sitemaps; a collection of Sitemap objects for index sitemaps, an
     * empty collection for non-index sitemaps
     *
     * @var array
     */
    private $children = [];

    /**
     * @var array Collection of URLs found in this sitemap
     */
    private $urls = null;

    /**
     * @param SitemapConfiguration $configuration
     */
    public function setConfiguration(SitemapConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return SitemapConfiguration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @return string
     */
    public function getType()
    {
        if (is_null($this->type)) {
            $this->type = $this->createIdentifier()->getType($this->getContent());
        }

        return $this->type;
    }

    /**
     * @return bool
     */
    public function isIndex()
    {
        return $this->getType() == self::SITEMAP_INDEX_TYPE;
    }

    /**
     * @return bool
     */
    public function isSitemap()
    {
        return !is_null($this->getType());
    }

    /**
     * @return string[]
     */
    public function getUrls()
    {
        if (is_null($this->urls)) {
            $this->urls = [];

            $extractorClass = $this->configuration->getExtractorClassForType($this->getType());
            if (is_null($extractorClass)) {
                return [];
            }

            /* @var UrlExtractorInterface $extractor */
            $extractor = new $extractorClass;
            $urls = $extractor->extract($this->getContent());

            foreach ($urls as $url) {
                $normalisedUrl = (string)new NormalisedUrl($url);
                if (!array_key_exists($normalisedUrl, $this->urls)) {
                    $this->urls[$normalisedUrl] = true;
                }
            }
        }

        return array_keys($this->urls);
    }

    /**
     * @param Sitemap $sitemap
     * @return bool
     */
    public function addChild(Sitemap $sitemap)
    {
        if (!$this->isIndex()) {
            return false;
        }

        $childUrl = new NormalisedUrl($sitemap->getUrl());
        $childIndex = md5((string)$childUrl);

        $this->children[$childIndex] = $sitemap;
        return true;
    }

    /**
     * @return Sitemap[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return Identifier
     */
    private function createIdentifier()
    {
        if (is_null($this->identifier)) {
            $this->identifier = new Identifier();

            $sitemapsOrgXmlMatcher = new SitemapsOrgXml();
            $sitemapsOrgXmlMatcher->setType('sitemaps.org.xml');
            $this->identifier->addMatcher($sitemapsOrgXmlMatcher);

            $sitemapsOrgTxtMatcher = new SitemapsOrgTxt();
            $sitemapsOrgTxtMatcher->setType('sitemaps.org.txt');
            $this->identifier->addMatcher($sitemapsOrgTxtMatcher);

            $rssFeedMatcher = new RssFeed();
            $rssFeedMatcher->setType('application/rss+xml');
            $this->identifier->addMatcher($rssFeedMatcher);

            $atomFeedMatcher = new AtomFeed();
            $atomFeedMatcher->setType('application/atom+xml');
            $this->identifier->addMatcher($atomFeedMatcher);

            $sitemapsOrgXmlIndexMatcher = new SitemapsOrgXmlIndex();
            $sitemapsOrgXmlIndexMatcher->setType('sitemaps.org.xml.index');
            $this->identifier->addMatcher($sitemapsOrgXmlIndexMatcher);
        }

        return $this->identifier;
    }
}
