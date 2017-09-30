<?php
namespace webignition\WebResource\Sitemap;

use Guzzle\Http\Message\Response;
use webignition\WebResource\Sitemap\Identifier\Identifier;
use webignition\WebResource\Sitemap\UrlExtractor\NewsFeedUrlExtractor;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgTxtUrlExtractor;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlIndexUrlExtractor;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlUrlExtractor;

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
            TypeInterface::TYPE_SITEMAPS_ORG_XML => new SitemapsOrgXmlUrlExtractor(),
            TypeInterface::TYPE_SITEMAPS_ORG_TXT => new SitemapsOrgTxtUrlExtractor(),
            TypeInterface::TYPE_ATOM => $newsFeedExtractor,
            TypeInterface::TYPE_RSS => $newsFeedExtractor,
            TypeInterface::TYPE_SITEMAPS_ORG_XML_INDEX => new SitemapsOrgXmlIndexUrlExtractor(),
        ];

        $this->identifier = new Identifier();
    }

    /**
     * @param Response $httpResponse
     *
     * @return Sitemap
     */
    public function create(Response $httpResponse)
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($httpResponse);

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
