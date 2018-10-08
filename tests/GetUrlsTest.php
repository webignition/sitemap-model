<?php

namespace webignition\WebResource\Sitemap\Tests;

use Psr\Http\Message\UriInterface;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Tests\Services\ResponseFactory;
use webignition\WebResource\TestingTools\FixtureLoader;

class GetUrlsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getUrlsDataProvider
     *
     * @param string $responseContent
     * @param string $responseContentType
     * @param string[] $expectedUrls
     */
    public function testGetUrls(string $responseContent, string $responseContentType, array $expectedUrls)
    {
        $factory = new Factory();

        $response = ResponseFactory::create($responseContent, $responseContentType);

        $sitemap = $factory->createFromResponse($response, \Mockery::mock(UriInterface::class));

        $this->assertEquals($expectedUrls, $sitemap->getUrls());
    }

    /**
     * @return array
     */
    public function getUrlsDataProvider()
    {
        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';

        return [
            'atom' => [
                'responseContent' => FixtureLoader::load('atom.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_ATOM,
                'expectedUrls' => [
                    'http://example.com/from-atom',
                ],
            ],
            'rss' => [
                'responseContent' => FixtureLoader::load('rss.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_RSS,
                'expectedUrls' => [
                    'http://example.com/from-rss',
                ],
            ],
            'sitemaps org xml' => [
                'responseContent' => FixtureLoader::load('sitemap.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org xml v0.84' => [
                'responseContent' => FixtureLoader::load('sitemap.0.84.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org txt' => [
                'responseContent' => FixtureLoader::load('sitemap.txt'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_TXT,
                'expectedUrls' => [
                    'http://example.com/txt/1',
                    'http://example.com/txt/2',
                    'http://example.com/txt/3',
                ],
            ],
            'sitemaps org xml index' => [
                'responseContent' => FixtureLoader::load('sitemap.index.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
            'sitemaps org xml index google.com v0.84' => [
                'responseContent' => FixtureLoader::load('sitemap.index.google.com.0.84.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
            'parent location urls only' => [
                'responseContent' => FixtureLoader::load('sitemap.with-images.xml'),
                'responseContentType' => ContentTypes::CONTENT_TYPE_XML,
                'expectedUrls' => [
                    'http://example.com/xml-with-images/1',
                    'http://example.com/xml-with-images/2',
                    'http://example.com/xml-with-images/3',
                ],
            ],
        ];
    }
}
