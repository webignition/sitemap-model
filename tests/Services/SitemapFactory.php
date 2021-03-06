<?php

namespace webignition\WebResource\Sitemap\Tests\Services;

use Psr\Http\Message\UriInterface;
use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\TestingTools\ContentTypes;
use webignition\WebResource\TestingTools\FixtureLoader;
use webignition\WebResourceInterfaces\SitemapInterface;

class SitemapFactory
{
    /**
     * @return SitemapInterface
     *
     * @throws InvalidContentTypeException
     */
    public static function createXmlIndexSitemap(): SitemapInterface
    {
        $content = FixtureLoader::load('sitemap.index.xml');

        $response = ResponseFactory::create($content, ContentTypes::CONTENT_TYPE_XML);

        $factory = new Factory();
        return $factory->createFromResponse($response, \Mockery::mock(UriInterface::class));
    }

    /**
     * @param string $content
     * @param null|UriInterface $uri
     *
     * @return SitemapInterface
     *
     * @throws InvalidContentTypeException
     */
    public static function createXmlSitemap(string $content, ?UriInterface $uri = null): SitemapInterface
    {
        if (empty($uri)) {
            $uri = \Mockery::mock(UriInterface::class);
        }

        $response = ResponseFactory::create($content, ContentTypes::CONTENT_TYPE_XML);

        $factory = new Factory();
        return $factory->createFromResponse($response, $uri);
    }
}
