<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\HttpResponseFactory;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Sitemap;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->factory = new Factory();
    }

    /**
     * @dataProvider createDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     */
    public function testCreate($fixtureName, $contentType, $expectedUrls)
    {
        $fixture = FixtureLoader::load($fixtureName);
        $httpResponse = HttpResponseFactory::create($fixture, $contentType);

        $sitemap = $this->factory->create($httpResponse);

        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $this->assertEquals($expectedUrls, $sitemap->getUrls());
    }

    /**
     * @return array
     */
    public function createDataProvider()
    {
        return [
            'atom' => [
                'fixtureName' => 'atom.xml',
                'contentType' => 'application/atom+xml',
                'expectedUrls' => [
                    'http://example.com/from-atom',
                ],
            ],
            'rss' => [
                'fixtureName' => 'rss.xml',
                'contentType' => 'application/rss+xml',
                'expectedUrls' => [
                    'http://example.com/from-rss',
                ],
            ],
            'sitemaps org xml' => [
                'fixtureName' => 'sitemap.xml',
                'contentType' => 'text/xml',
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org txt' => [
                'fixtureName' => 'sitemap.txt',
                'contentType' => 'text/plain',
                'expectedUrls' => [
                    'http://example.com/txt/1',
                    'http://example.com/txt/2',
                    'http://example.com/txt/3',
                ],
            ],
            'sitemaps org xml index' => [
                'fixtureName' => 'sitemap.index.xml',
                'contentType' => 'text/xml',
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
        ];
    }
}
