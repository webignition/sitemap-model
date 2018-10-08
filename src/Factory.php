<?php

namespace webignition\WebResource\Sitemap;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Sitemap\Identifier\Identifier;
use webignition\WebResource\Sitemap\UrlExtractor\NewsFeedUrlExtractor;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgTxtUrlExtractor;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlIndexUrlExtractor;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlUrlExtractor;
use webignition\WebResourceInterfaces\SitemapInterface;

class Factory
{
    const EXCEPTION_UNKNOWN_TYPE_CODE = 1;
    const EXCEPTION_UNKNOWN_TYPE_MESSAGE = 'Unknown sitemap type';

    /**
     * @var Identifier
     */
    private $identifier;

    /**
     * @var array
     */
    private $typeExtractorMap;

    public function __construct()
    {
        $newsFeedExtractor = new NewsFeedUrlExtractor();

        $this->typeExtractorMap = [
            SitemapInterface::TYPE_SITEMAPS_ORG_XML => new SitemapsOrgXmlUrlExtractor(),
            SitemapInterface::TYPE_SITEMAPS_ORG_TXT => new SitemapsOrgTxtUrlExtractor(),
            SitemapInterface::TYPE_ATOM => $newsFeedExtractor,
            SitemapInterface::TYPE_RSS => $newsFeedExtractor,
            SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX => new SitemapsOrgXmlIndexUrlExtractor(),
        ];

        $this->identifier = new Identifier();
    }

    /**
     * @param ResponseInterface $response
     * @param UriInterface $uri
     *
     * @return SitemapInterface
     */
    public function createFromResponse(ResponseInterface $response, UriInterface $uri = null): SitemapInterface
    {
        /* @var Sitemap $sitemap */
        $sitemap = null;

        try {
            $sitemap = Sitemap::createFromResponse($uri, $response);
        } catch (InvalidContentTypeException $invalidContentTypeException) {
            throw new \RuntimeException(
                self::EXCEPTION_UNKNOWN_TYPE_MESSAGE,
                self::EXCEPTION_UNKNOWN_TYPE_CODE
            );
        }

        $content = $sitemap->getContent();
        $type = $this->identifier->getType($content);

        if (empty($type)) {
            throw new \RuntimeException(
                self::EXCEPTION_UNKNOWN_TYPE_MESSAGE,
                self::EXCEPTION_UNKNOWN_TYPE_CODE
            );
        }

        $urlExtractor = $this->typeExtractorMap[$type];

        $sitemap->setType($type);
        $sitemap->setUrlExtractor($urlExtractor);

        return $sitemap;
    }
}
