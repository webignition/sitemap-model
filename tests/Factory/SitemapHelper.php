<?php

namespace webignition\WebResource\Sitemap\Tests\Factory;

use Psr\Http\Message\UriInterface;
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
     */
    public static function createXmlIndexSitemap(UriInterface $uri = null): SitemapInterface
    {
        $response = ResponseFactory::createFromFixture('sitemap.index.xml', ContentTypes::CONTENT_TYPE_XML);

        $factory = new Factory();

        return $factory->createFromResponse($response, $uri);
    }

    /**
     * @param string $fixtureName
     * @param UriInterface $uri
     *
     * @return SitemapInterface
     */
    public static function createXmlSitemap(string $fixtureName, ?UriInterface $uri = null): SitemapInterface
    {
        $response = ResponseFactory::createFromFixture($fixtureName, ContentTypes::CONTENT_TYPE_XML);

        $factory = new Factory();

        return $factory->createFromResponse($response, $uri);
    }
}
