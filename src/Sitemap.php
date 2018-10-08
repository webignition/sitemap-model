<?php

namespace webignition\WebResource\Sitemap;

use webignition\InternetMediaType\InternetMediaType;
use webignition\InternetMediaTypeInterface\InternetMediaTypeInterface;
use webignition\NormalisedUrl\NormalisedUrl;
use webignition\WebResource\Sitemap\UrlExtractor\UrlExtractorInterface;
use webignition\WebResource\WebResource;
use webignition\WebResourceInterfaces\SitemapInterface;

class Sitemap extends WebResource implements SitemapInterface
{
    const DEFAULT_CONTENT_TYPE_TYPE = 'text';
    const DEFAULT_CONTENT_TYPE_SUBTYPE = 'xml';

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

    public function getType(): string
    {
        return $this->type;
    }

    public function isIndex(): bool
    {
        return $this->getType() == SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX;
    }

    public function isSitemap(): bool
    {
        return !is_null($this->getType());
    }

    /**
     * @return string[]
     */
    public function getUrls(): array
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

    public function addChild(SitemapInterface $sitemap): bool
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
     * @return SitemapInterface[]
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function setType(string $type)
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

    public static function getDefaultContentType(): InternetMediaType
    {
        $contentType = new InternetMediaType();
        $contentType->setType(self::DEFAULT_CONTENT_TYPE_TYPE);
        $contentType->setSubtype(self::DEFAULT_CONTENT_TYPE_SUBTYPE);

        return $contentType;
    }

    public static function models(InternetMediaTypeInterface $internetMediaType): bool
    {
        return in_array($internetMediaType->getTypeSubtypeString(), self::getModelledContentTypeStrings());
    }

    public static function getModelledContentTypeStrings(): array
    {
        return [
            ContentTypes::CONTENT_TYPE_ATOM,
            ContentTypes::CONTENT_TYPE_RSS,
            ContentTypes::CONTENT_TYPE_XML,
            ContentTypes::CONTENT_TYPE_TXT,
        ];
    }
}
