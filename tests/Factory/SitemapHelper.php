<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use Psr\Http\Message\UriInterface;
use webignition\InternetMediaType\Parser\ParseException as InternetMediaTypeParseException;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\TestingTools\ContentTypes;
use webignition\WebResource\TestingTools\ResponseFactory;
use webignition\WebResourceInterfaces\SitemapInterface;

class SitemapHelper
{
    /**
     * @param UriInterface $uri
     *
     * @return SitemapInterface
     *
     * @throws InternetMediaTypeParseException
     */
    public static function createXmlIndexSitemap(UriInterface $uri = null)
    {
        $response = ResponseFactory::createFromFixture('sitemap.index.xml', ContentTypes::CONTENT_TYPE_XML);

        $factory = new Factory();

        return $factory->create($response, $uri);
    }

    /**
     * @param string $fixtureName
     * @param UriInterface $uri
     *
     * @return SitemapInterface
     *
     * @throws InternetMediaTypeParseException
     */
    public static function createXmlSitemap($fixtureName, UriInterface $uri = null)
    {
        $response = ResponseFactory::createFromFixture($fixtureName, ContentTypes::CONTENT_TYPE_XML);

        $factory = new Factory();

        return $factory->create($response, $uri);
    }
}
