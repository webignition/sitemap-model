<?php

namespace webignition\WebResource\Sitemap\Tests;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use webignition\InternetMediaType\InternetMediaType;
use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Sitemap\ContentTypes;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\SitemapProperties;
use webignition\WebResourceInterfaces\SitemapInterface;

class SitemapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @throws InvalidContentTypeException
     */
    public function testCreateFromContentWithInvalidContentType()
    {
        $this->expectException(InvalidContentTypeException::class);
        $this->expectExceptionMessage('Invalid content type "image/png"');

        new Sitemap(SitemapProperties::create([
            SitemapProperties::ARG_CONTENT_TYPE => new InternetMediaType('image', 'png')
        ]));
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
     * @throws InvalidContentTypeException
     */
    public function testSetContentTypeInvalidContentType()
    {
        $sitemap = Sitemap::createFromContent('sitemap content', null, SitemapInterface::TYPE_SITEMAPS_ORG_XML);

        $this->assertEquals(ContentTypes::CONTENT_TYPE_TEXT_XML, (string)$sitemap->getContentType());

        $contentType = new InternetMediaType('application', 'octetstream');

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

        $currentResponse = \Mockery::mock(ResponseInterface::class);
        $currentResponse
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn(ContentTypes::CONTENT_TYPE_TEXT_XML);

        $currentResponse
            ->shouldReceive('getBody')
            ->andReturn($responseBody);

        $newResponse = \Mockery::mock(ResponseInterface::class);
        $newResponse
            ->shouldReceive('getHeaderLine')
            ->with(Sitemap::HEADER_CONTENT_TYPE)
            ->andReturn('image/jpg');

        $sitemap = Sitemap::createFromResponse($uri, $currentResponse, SitemapInterface::TYPE_SITEMAPS_ORG_XML);

        $this->expectException(InvalidContentTypeException::class);
        $this->expectExceptionMessage('Invalid content type "image/jpg"');

        $sitemap->setResponse($newResponse);
    }

    public function testGetModelledContentTypeStrings()
    {
        $this->assertEquals(
            [
                ContentTypes::CONTENT_TYPE_ATOM,
                ContentTypes::CONTENT_TYPE_RSS,
                ContentTypes::CONTENT_TYPE_APPLICATION_XML,
                ContentTypes::CONTENT_TYPE_TEXT_XML,
                ContentTypes::CONTENT_TYPE_TXT,
            ],
            Sitemap::getModelledContentTypeStrings()
        );
    }
}
