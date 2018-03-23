<?php

namespace webignition\WebResource\Sitemap;

use webignition\NormalisedUrl\NormalisedUrl;
use webignition\WebResource\Sitemap\UrlExtractor\UrlExtractorInterface;
use webignition\WebResource\WebResource;
use webignition\WebResourceInterfaces\SitemapInterface;

class Sitemap extends WebResource implements SitemapInterface
{
    /**
     * @var string
     */
    private $type = null;

    /**
     * @var UrlExtractorInterface
     */
    private $urlExtractor;

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
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function isIndex()
    {
        return $this->getType() == SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX;
    }

    /**
     * {@inheritdoc}
     */
    public function isSitemap()
    {
        return !is_null($this->getType());
    }

    /**
     * {@inheritdoc}
     */
    public function getUrls()
    {
        if (is_null($this->urls)) {
            $this->urls = [];

            $urls = $this->urlExtractor->extract($this->getContent());

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
     * {@inheritdoc}
     */
    public function addChild(SitemapInterface $sitemap)
    {
        if (!$this->isIndex()) {
            return false;
        }

        $childUrl = new NormalisedUrl($sitemap->getUri());
        $childIndex = md5((string)$childUrl);

        $this->children[$childIndex] = $sitemap;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param UrlExtractorInterface $urlExtractor
     */
    public function setUrlExtractor(UrlExtractorInterface $urlExtractor)
    {
        $this->urlExtractor = $urlExtractor;
    }
}
