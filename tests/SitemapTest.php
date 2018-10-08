<?php

namespace webignition\WebResource\Sitemap\Tests;

use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use webignition\InternetMediaType\InternetMediaType;
use webignition\InternetMediaTypeInterface\InternetMediaTypeInterface;
use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Sitemap\ContentTypes;
use webignition\WebResource\Sitemap\Sitemap;

class SitemapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws InvalidContentTypeException
     */
    public function testCreateFromContentWithInvalidContentType()
    {
        $uri = \Mockery::mock(UriInterface::class);

        $contentType = new InternetMediaType();
        $contentType->setType('image');
        $contentType->setSubtype('png');

        $this->expectException(InvalidContentTypeException::class);
        $this->expectExceptionMessage('Invalid content type "image/png"');

        Sitemap::createFromContent($uri, 'content', $contentType);
    }

    /**
     * @dataProvider createFromContentDataProvider
     *
     * @param InternetMediaTypeInterface|null $contentType
     * @param string $expectedContentTypeString
     *
     * @throws InvalidContentTypeException
     */
    public function testCreateFromContent(?InternetMediaTypeInterface $contentType, string $expectedContentTypeString)
    {
        $uri = \Mockery::mock(UriInterface::class);

        $content = 'sitemap content';

        $sitemap = Sitemap::createFromContent($uri, $content, $contentType);

        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $this->assertEquals($uri, $sitemap->getUri());
        $this->assertEquals($content, $sitemap->getContent());
        $this->assertEquals($expectedContentTypeString, (string)$sitemap->getContentType());
        $this->assertNull($sitemap->getResponse());
    }

    public function createFromContentDataProvider(): array
    {
        return [
            'no content type' => [
                'contentType' => null,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
            ],
            'atom content type' => [
                'contentType' => $this->createContentType('application', 'atom+xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_ATOM,
            ],
            'rss content type' => [
                'contentType' => $this->createContentType('application', 'rss+xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_RSS,
            ],
            'text/xml content type' => [
                'contentType' => $this->createContentType('text', 'xml'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
            ],
            'text/plain content type' => [
                'contentType' => $this->createContentType('text', 'plain'),
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_TXT,
            ],
        ];
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testCreateFromResponseWithInvalidContentType()
    {
        $uri = \Mockery::mock(UriInterface::class);

        $response = \Mockery::mock(ResponseInterface::class);
        $response
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn('image/jpg');

        $this->expectException(InvalidContentTypeException::class);
        $this->expectExceptionMessage('Invalid content type "image/jpg"');

        Sitemap::createFromResponse($uri, $response);
    }

    /**
     * @dataProvider createFromResponseDataProvider
     *
     * @param string $responseContentTypeHeader
     * @param string $expectedContentTypeString
     *
     * @throws InvalidContentTypeException
     */
    public function testCreateFromResponse(string $responseContentTypeHeader, string $expectedContentTypeString)
    {
        $content = 'sitemap content';

        $uri = \Mockery::mock(UriInterface::class);

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

        $sitemap = Sitemap::createFromResponse($uri, $response);

        $this->assertInstanceOf(Sitemap::class, $sitemap);
        $this->assertEquals($uri, $sitemap->getUri());
        $this->assertEquals($content, $sitemap->getContent());
        $this->assertEquals($expectedContentTypeString, (string)$sitemap->getContentType());
        $this->assertEquals($response, $sitemap->getResponse());
    }

    public function createFromResponseDataProvider(): array
    {
        return [
            'atom content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_ATOM,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_ATOM,
            ],
            'rss content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_RSS,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_RSS,
            ],
            'text/xml content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_XML,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_XML,
            ],
            'text/plain content type' => [
                'responseContentTypeHeader' => ContentTypes::CONTENT_TYPE_TXT,
                'expectedContentTypeString' => ContentTypes::CONTENT_TYPE_TXT,
            ],
        ];
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testSetContentTypeInvalidContentType()
    {
        $uri = \Mockery::mock(UriInterface::class);

        $sitemap = Sitemap::createFromContent($uri, 'sitemap content');

        $this->assertEquals(ContentTypes::CONTENT_TYPE_XML, (string)$sitemap->getContentType());

        $contentType = $this->createContentType('application', 'octetstream');

        $this->expectException(InvalidContentTypeException::class);
        $this->expectExceptionMessage('Invalid content type "application/octetstream"');

        $sitemap->setContentType($contentType);
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testSetResponseWithInvalidContentType()
    {
        $uri = \Mockery::mock(UriInterface::class);

        $responseBody = \Mockery::mock(StreamInterface::class);
        $responseBody
            ->shouldReceive('__toString')
            ->andReturn('');

        /* @var ResponseInterface|MockInterface $currentResponse */
        $currentResponse = \Mockery::mock(ResponseInterface::class);
        $currentResponse
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn(ContentTypes::CONTENT_TYPE_XML);

        $currentResponse
            ->shouldReceive('getBody')
            ->andReturn($responseBody);

        /* @var ResponseInterface|MockInterface $newResponse */
        $newResponse = \Mockery::mock(ResponseInterface::class);
        $newResponse
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn('image/jpg');

        $sitemap = Sitemap::createFromResponse($uri, $currentResponse);

        $this->expectException(InvalidContentTypeException::class);
        $this->expectExceptionMessage('Invalid content type "image/jpg"');

        $sitemap->setResponse($newResponse);
    }

    private function createContentType(string $type, string $subtype): InternetMediaTypeInterface
    {
        $contentType = new InternetMediaType();
        $contentType->setType($type);
        $contentType->setSubtype($subtype);

        return $contentType;
    }
}
