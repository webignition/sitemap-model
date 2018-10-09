<?php

namespace webignition\WebResource\Sitemap\Tests;

use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use webignition\InternetMediaType\InternetMediaType;
use webignition\InternetMediaTypeInterface\InternetMediaTypeInterface;
use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Exception\ReadOnlyResponseException;
use webignition\WebResource\Exception\UnseekableResponseException;
use webignition\WebResource\Sitemap\ContentTypes;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\SitemapProperties;
use webignition\WebResourceInterfaces\SitemapInterface;

class SitemapMutationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Sitemap
     */
    private $sitemap;

    /**
     * @var Sitemap
     */
    private $updatedSitemap;

    protected function assertPostConditions()
    {
        parent::assertPostConditions();

        $this->assertInstanceOf(Sitemap::class, $this->sitemap);
        $this->assertInstanceOf(Sitemap::class, $this->updatedSitemap);
        $this->assertNotEquals(spl_object_hash($this->sitemap), spl_object_hash($this->updatedSitemap));
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testSetUri()
    {
        $currentUri = \Mockery::mock(UriInterface::class);
        $newUri = \Mockery::mock(UriInterface::class);

        $this->sitemap = new Sitemap(SitemapProperties::create([
            SitemapProperties::ARG_URI => $currentUri,
            SitemapProperties::ARG_TYPE => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
        ]));

        $this->assertEquals($currentUri, $this->sitemap->getUri());

        $this->updatedSitemap = $this->sitemap->setUri($newUri);
        $this->assertEquals($newUri, $this->updatedSitemap->getUri());
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testSetContentType()
    {
        $this->sitemap = Sitemap::createFromContent('', null, SitemapInterface::TYPE_SITEMAPS_ORG_XML);
        $this->assertEquals(ContentTypes::CONTENT_TYPE_XML, (string)$this->sitemap->getContentType());

        $contentType = $this->createContentType('text', 'xml');
        $this->updatedSitemap = $this->sitemap->setContentType($contentType);

        $this->assertEquals(ContentTypes::CONTENT_TYPE_XML, (string)$this->updatedSitemap->getContentType());
    }

    /**
     * @throws InvalidContentTypeException
     * @throws ReadOnlyResponseException
     * @throws UnseekableResponseException
     */
    public function testSetContent()
    {
        $currentContent = 'current content';
        $newContent = 'new content';

        $this->sitemap = Sitemap::createFromContent($currentContent, null, SitemapInterface::TYPE_SITEMAPS_ORG_XML);
        $this->assertEquals($currentContent, $this->sitemap->getContent());

        $this->updatedSitemap = $this->sitemap->setContent($newContent);
        $this->assertEquals($newContent, $this->updatedSitemap->getContent());
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testSetResponseWithInvalidContentType()
    {
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
            ->andReturn(ContentTypes::CONTENT_TYPE_XML);

        $this->sitemap = Sitemap::createFromResponse(
            \Mockery::mock(UriInterface::class),
            $currentResponse,
            SitemapInterface::TYPE_SITEMAPS_ORG_XML
        );
        $this->updatedSitemap = $this->sitemap->setResponse($newResponse);

        $this->assertEquals($newResponse, $this->updatedSitemap->getResponse());
    }

    private function createContentType(string $type, string $subtype): InternetMediaTypeInterface
    {
        $contentType = new InternetMediaType();
        $contentType->setType($type);
        $contentType->setSubtype($subtype);

        return $contentType;
    }
}
