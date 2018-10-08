<?php

namespace webignition\WebResource\Sitemap\Tests;

use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
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
    }

    /**
     * @dataProvider createFromResponseUnknownTypeDataProvider
     *
     * @param string $responseContent
     * @param string $responseContentType
     */
    public function testCreateFromResponseUnknownType(string $responseContent, string $responseContentType)
    {
        $response = $this->createResponse($responseContent, $responseContentType);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unknown sitemap type');

        $this->factory->createFromResponse($response, \Mockery::mock(UriInterface::class));
    }

    public function createFromResponseUnknownTypeDataProvider(): array
    {
        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';

        return [
            'html document' => [
                'responseContent' => FixtureLoader::load('empty-document.html'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_HTML,
            ],
            'plain text' => [
                'responseContent' => FixtureLoader::load('plain.txt'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_TXT,
            ],
            'invalid xml' => [
                'responseContent' => FixtureLoader::load('sitemap.invalid.xml'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_XML,
            ],
            'empty xml' => [
                'responseContent' => FixtureLoader::load(''),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_XML,
            ],
            'xml no namespace' => [
                'responseContent' => FixtureLoader::load('sitemap.no-namespace.xml'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_XML,
            ],
        ];
    }

    /**
     * @dataProvider createFromResponseDataProvider
     *
     * @param string $responseContent
     * @param string $responseContentType
     * @param string $expectedType
     */
    public function testCreateFromResponse(string $responseContent, string $responseContentType, string $expectedType)
    {
        $response = $this->createResponse($responseContent, $responseContentType);

        $sitemap = $this->factory->createFromResponse($response, \Mockery::mock(UriInterface::class));

        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $this->assertEquals($expectedType, $sitemap->getType());
    }

    public function createFromResponseDataProvider(): array
    {
        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';

        return [
            'atom' => [
                'responseContent' => FixtureLoader::load('atom.xml'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_ATOM,
                'expectedType' => SitemapInterface::TYPE_ATOM,
            ],
            'rss' => [
                'responseContent' => FixtureLoader::load('rss.xml'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_RSS,
                'expectedType' => SitemapInterface::TYPE_RSS,
            ],
            'sitemaps org xml' => [
                'responseContent' => FixtureLoader::load('sitemap.xml'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_XML,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedUrls' => [
                    'http://example.com/xml/1',
                    'http://example.com/xml/2',
                    'http://example.com/xml/3',
                ],
            ],
            'sitemaps org txt' => [
                'responseContent' => FixtureLoader::load('sitemap.txt'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_TXT,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedUrls' => [
                    'http://example.com/txt/1',
                    'http://example.com/txt/2',
                    'http://example.com/txt/3',
                ],
            ],
            'sitemaps org xml index' => [
                'responseContent' => FixtureLoader::load('sitemap.index.xml'),
                'responseContentType' => ResponseFactory::CONTENT_TYPE_XML,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedUrls' => [
                    'http://www.example.com/sitemap1.xml',
                    'http://www.example.com/sitemap2.xml',
                    'http://www.example.com/sitemap3.xml',
                ],
            ],
        ];
    }

    /**
     * @param string $content
     * @param string $contentType
     *
     * @return MockInterface|ResponseInterface
     */
    private function createResponse(string $content, string $contentType)
    {
        $responseBody = \Mockery::mock(StreamInterface::class);
        $responseBody
            ->shouldReceive('__toString')
            ->andReturn($content);

        $response = \Mockery::mock(ResponseInterface::class);
        $response
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn($contentType);

        $response
            ->shouldReceive('getBody')
            ->andReturn($responseBody);

        return $response;
    }
}
