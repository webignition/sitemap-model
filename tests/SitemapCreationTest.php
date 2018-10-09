<?php

namespace webignition\WebResource\Sitemap\Tests;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use webignition\InternetMediaType\InternetMediaType;
use webignition\InternetMediaTypeInterface\InternetMediaTypeInterface;
use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Sitemap\ContentTypes;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\SitemapProperties;
use webignition\WebResourceInterfaces\SitemapInterface;

class SitemapCreationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Sitemap
     */
    private $sitemap;

    protected function assertPostConditions()
    {
        parent::assertPostConditions();

        $this->assertInstanceOf(Sitemap::class, $this->sitemap);
    }

    /**
     * @dataProvider createFromContentDataProvider
     *
     * @param InternetMediaTypeInterface|null $contentType
     * @param string $expectedContentTypeString
     * @param string $type
     *
     * @throws InvalidContentTypeException
     */
    public function testCreateWithContent(
        ?InternetMediaTypeInterface $contentType,
        string $expectedContentTypeString,
        string $type
    ) {
        $uri = \Mockery::mock(UriInterface::class);
        $content = 'sitemap content';

        $this->sitemap = new Sitemap(SitemapProperties::create([
            SitemapProperties::ARG_URI => $uri,
            SitemapProperties::ARG_CONTENT_TYPE => $contentType,
            SitemapProperties::ARG_CONTENT => $content,
            SitemapProperties::ARG_TYPE => $type,
        ]));

        $this->assertEquals($uri, $this->sitemap->getUri());
        $this->assertEquals($content, $this->sitemap->getContent());
        $this->assertEquals($expectedContentTypeString, (string)$this->sitemap->getContentType());
        $this->assertNull($this->sitemap->getResponse());
        $this->assertEquals($type, $this->sitemap->getType());
    }


    /**
     * @dataProvider createFromContentDataProvider
     *
     * @param InternetMediaTypeInterface|null $contentType
     * @param string $expectedContentTypeString
     * @param string $type
     *
     * @throws InvalidContentTypeException
     */
    public function testCreateFromContent(
        ?InternetMediaTypeInterface $contentType,
        string $expectedContentTypeString,
        string $type
    ) {
        $content = 'sitemap content';
        $this->sitemap = Sitemap::createFromContent($content, $contentType, $type);

        $this->assertInstanceOf(Sitemap::class, $this->sitemap);
        $this->assertNull($this->sitemap->getUri());
        $this->assertEquals($content, $this->sitemap->getContent());
        $this->assertEquals($expectedContentTypeString, (string)$this->sitemap->getContentType());
        $this->assertNull($this->sitemap->getResponse());
        $this->assertEquals($type, $this->sitemap->getType());
    }

    public function createFromContentDataProvider(): array
    {
        return [
            'no content type' => [
                'contentType' => null,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
            ],
            'atom content type' => [
                'contentType' => new InternetMediaType('application', 'atom+xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_ATOM,
                'type' => SitemapInterface::TYPE_ATOM,
            ],
            'rss content type' => [
                'contentType' => new InternetMediaType('application', 'rss+xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_RSS,
                'type' => SitemapInterface::TYPE_RSS,
            ],
            'text/xml content type, sitemap.xml type' => [
                'contentType' => new InternetMediaType('text', 'xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
            ],
            'text/xml content type, sitemap.index.xml type' => [
                'contentType' => new InternetMediaType('text', 'xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
            ],
            'text/plain content type' => [
                'contentType' => new InternetMediaType('text', 'plain'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_TXT,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
            ],
        ];
    }

    /**
     * @dataProvider createFromResponseDataProvider
     *
     * @param string $responseContentTypeHeader
     * @param string $expectedContentTypeString
     * @param string $type
     *
     * @throws InvalidContentTypeException
     */
    public function testCreateWithResponse(
        string $responseContentTypeHeader,
        string $expectedContentTypeString,
        string $type
    ) {
        $content = 'sitemap content';
        $uri = \Mockery::mock(UriInterface::class);
        $response = $this->createResponse($content, $responseContentTypeHeader);

        $this->sitemap = new Sitemap(SitemapProperties::create([
            SitemapProperties::ARG_URI => $uri,
            SitemapProperties::ARG_RESPONSE => $response,
            SitemapProperties::ARG_TYPE => $type,
        ]));

        $this->assertEquals($uri, $this->sitemap->getUri());
        $this->assertEquals($content, $this->sitemap->getContent());
        $this->assertEquals($expectedContentTypeString, (string)$this->sitemap->getContentType());
        $this->assertEquals($response, $this->sitemap->getResponse());
        $this->assertEquals($type, $this->sitemap->getType());
    }

    /**
     * @dataProvider createFromResponseDataProvider
     *
     * @param string $responseContentTypeHeader
     * @param string $expectedContentTypeString
     * @param string $type
     *
     * @throws InvalidContentTypeException
     */
    public function testCreateFromResponse(
        string $responseContentTypeHeader,
        string $expectedContentTypeString,
        string $type
    ) {
        $content = 'sitemap content';
        $uri = \Mockery::mock(UriInterface::class);
        $response = $this->createResponse($content, $responseContentTypeHeader);

        $this->sitemap = Sitemap::createFromResponse($uri, $response, $type);

        $this->assertEquals($uri, $this->sitemap->getUri());
        $this->assertEquals($content, $this->sitemap->getContent());
        $this->assertEquals($expectedContentTypeString, (string)$this->sitemap->getContentType());
        $this->assertEquals($response, $this->sitemap->getResponse());
        $this->assertEquals($type, $this->sitemap->getType());
    }

    public function createFromResponseDataProvider(): array
    {
        return [
            'atom content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_ATOM,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_ATOM,
                'type' => SitemapInterface::TYPE_ATOM,
            ],
            'rss content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_RSS,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_RSS,
                'type' => SitemapInterface::TYPE_RSS,
            ],
            'text/xml content type, sitemap.xml type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_XML,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
            ],
            'text/xml content type, sitemap.index.xml type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_XML,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
            ],
            'text/plain content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_TXT,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_TXT,
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
            ],
        ];
    }

    private function createResponse(string $content, string $responseContentTypeHeader)
    {
        $responseBody = \Mockery::mock(StreamInterface::class);
        $responseBody
            ->shouldReceive('__toString')
            ->andReturn($content);

        $response = \Mockery::mock(ResponseInterface::class);
        $response
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn($responseContentTypeHeader);

        $response
            ->shouldReceive('getBody')
            ->andReturn($responseBody);

        return $response;
    }
}
