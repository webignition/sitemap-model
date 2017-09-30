<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\HttpResponseFactory;
use webignition\WebResource\Sitemap\Factory;

class IsSitemapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider isSitemapDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     * @param bool $expectedIsSitemap
     */
    public function testIsSitemap($fixtureName, $contentType, $expectedIsSitemap)
    {
        $factory = new Factory();

        $fixture = FixtureLoader::load($fixtureName);
        $httpResponse = HttpResponseFactory::create($fixture, $contentType);

        $sitemap = $factory->create($httpResponse);

        $this->assertEquals($expectedIsSitemap, $sitemap->isSitemap());
    }

    /**
     * @return array
     */
    public function isSitemapDataProvider()
    {
        return [
            'atom' => [
                'fixtureName' => FixtureLoader::ATOM_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_ATOM,
                'expectedIsSitemap' => true,
            ],
            'rss' => [
                'fixtureName' => FixtureLoader::RSS_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_RSS,
                'expectedIsSitemap' => true,
            ],
            'sitemaps org xml' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedIsSitemap' => true,
            ],
            'sitemaps org txt' => [
                'fixtureName' => FixtureLoader::SITEMAP_TXT_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_TXT,
                'expectedIsSitemap' => true,
            ],
            'sitemaps org xml index' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_INDEX_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedIsSitemap' => true,
            ],
        ];
    }
}
