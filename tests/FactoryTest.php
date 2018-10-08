<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\InternetMediaType\Parser\ParseException as InternetMediaTypeParseException;
use webignition\Tests\WebResource\Sitemap\Factory\UriFactory;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\TestingTools\FixtureLoader;
use webignition\WebResource\TestingTools\ResponseFactory;
use webignition\WebResourceInterfaces\SitemapInterface;

class FactoryTest extends \PHPUnit\Framework\TestCase
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

        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';
    }

    /**
     * @dataProvider createUnknownTypeDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     *
     * @throws InternetMediaTypeParseException
     */
    public function testCreateUnknownType($fixtureName, $contentType)
    {
        $response = ResponseFactory::createFromFixture($fixtureName, $contentType);

        $this->expectException(\RuntimeException::class);

        $this->factory->create($response, UriFactory::create('http://example.com'));
    }

    /**
     * @return array
     */
    public function createUnknownTypeDataProvider()
    {
        return [
            'html document' => [
                'fixtureName' => 'empty-document.html',
                'contentType' => ResponseFactory::CONTENT_TYPE_HTML,
            ],
            'plain text' => [
                'fixtureName' => 'plain.txt',
                'contentType' => ResponseFactory::CONTENT_TYPE_TXT,
            ],
            'invalid xml' => [
                'fixtureName' => 'sitemap.invalid.xml',
                'contentType' => ResponseFactory::CONTENT_TYPE_XML,
            ],
            'empty xml' => [
                'fixtureName' => null,
                'contentType' => ResponseFactory::CONTENT_TYPE_XML,
            ],
            'xml no namespace' => [
                'fixtureName' => 'sitemap.no-namespace.xml',
                'contentType' => ResponseFactory::CONTENT_TYPE_XML,
            ],
        ];
    }

    /**
     * @dataProvider createDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     * @param string $expectedType
     *
     * @throws InternetMediaTypeParseException
     */
    public function testCreate($fixtureName, $contentType, $expectedType)
    {
        $response = ResponseFactory::createFromFixture($fixtureName, $contentType);

        $sitemap = $this->factory->create($response, UriFactory::create('http://example.com'));

        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $this->assertEquals($expectedType, $sitemap->getType());
    }

    /**
     * @return array
     */
    public function createDataProvider()
    {
        return [
            'atom' => [
                'fixtureName' => 'atom.xml',
                'contentType' => ResponseFactory::CONTENT_TYPE_ATOM,
                'expectedType' => SitemapInterface::TYPE_ATOM,
            ],
            'rss' => [
                'fixtureName' => 'rss.xml',
                'contentType' => ResponseFactory::CONTENT_TYPE_RSS,
                'expectedType' => SitemapInterface::TYPE_RSS,
            ],
            'sitemaps org xml' => [
                'fixtureName' => 'sitemap.xml',
                'contentType' => ResponseFactory::CONTENT_TYPE_XML,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org txt' => [
                'fixtureName' => 'sitemap.txt',
                'contentType' => ResponseFactory::CONTENT_TYPE_TXT,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedUrls' => [
                    'http://example.com/txt/1',
                    'http://example.com/txt/2',
                    'http://example.com/txt/3',
                ],
            ],
            'sitemaps org xml index' => [
                'fixtureName' => 'sitemap.index.xml',
                'contentType' => ResponseFactory::CONTENT_TYPE_XML,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
        ];
    }
}
