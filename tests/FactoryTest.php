<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\HttpResponseFactory;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\TypeInterface;

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
     * @dataProvider createUnknownTypeDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     */
    public function testCreateUnknownType($fixtureName, $contentType)
    {
        $fixture = FixtureLoader::load($fixtureName);
        $httpResponse = HttpResponseFactory::create($fixture, $contentType);

        $this->setExpectedException(\RuntimeException::class);

        $this->factory->create($httpResponse);
    }

    /**
     * @return array
     */
    public function createUnknownTypeDataProvider()
    {
        return [
            'html document' => [
                'fixtureName' => FixtureLoader::HTML_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_HTML,
            ],
            'plain text' => [
                'fixtureName' => FixtureLoader::TEXT_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_TXT,
            ],
            'invalid xml' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_INVALID_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
            ],
        ];
    }

    /**
     * @dataProvider createDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     * @param string $expectedType
     */
    public function testCreate($fixtureName, $contentType, $expectedType)
    {
        $fixture = FixtureLoader::load($fixtureName);
        $httpResponse = HttpResponseFactory::create($fixture, $contentType);

        $sitemap = $this->factory->create($httpResponse);

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
                'fixtureName' => FixtureLoader::ATOM_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_ATOM,
                'expectedType' => TypeInterface::TYPE_ATOM,
            ],
            'rss' => [
                'fixtureName' => FixtureLoader::RSS_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_RSS,
                'expectedType' => TypeInterface::TYPE_RSS,
            ],
            'sitemaps org xml' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedType' => TypeInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org txt' => [
                'fixtureName' => FixtureLoader::SITEMAP_TXT_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_TXT,
                'expectedType' => TypeInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedUrls' => [
                    'http://example.com/txt/1',
                    'http://example.com/txt/2',
                    'http://example.com/txt/3',
                ],
            ],
            'sitemaps org xml index' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_INDEX_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedType' => TypeInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
        ];
    }
}
