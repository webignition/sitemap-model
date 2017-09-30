<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\HttpResponseFactory;
use webignition\WebResource\Sitemap\Factory;

class GetUrlsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getUrlsDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     * @param string[] $expectedUrls
     */
    public function testGetUrls($fixtureName, $contentType, $expectedUrls)
    {
        $factory = new Factory();

        $fixture = FixtureLoader::load($fixtureName);
        $httpResponse = HttpResponseFactory::create($fixture, $contentType);

        $sitemap = $factory->create($httpResponse);

        $this->assertEquals($expectedUrls, $sitemap->getUrls());
    }

    /**
     * @return array
     */
    public function getUrlsDataProvider()
    {
        return [
            'atom' => [
                'fixtureName' => FixtureLoader::ATOM_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_ATOM,
                'expectedUrls' => [
                    'http://example.com/from-atom',
                ],
            ],
            'rss' => [
                'fixtureName' => FixtureLoader::RSS_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_RSS,
                'expectedUrls' => [
                    'http://example.com/from-rss',
                ],
            ],
            'sitemaps org xml' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org txt' => [
                'fixtureName' => FixtureLoader::SITEMAP_TXT_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_TXT,
                'expectedUrls' => [
                    'http://example.com/txt/1',
                    'http://example.com/txt/2',
                    'http://example.com/txt/3',
                ],
            ],
            'sitemaps org xml index' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_INDEX_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
            'parent location urls only' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_WITH_IMAGES_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://example.com/xml-with-images/1',
                    'http://example.com/xml-with-images/2',
                    'http://example.com/xml-with-images/3',
                ],
            ],
        ];
    }
}
