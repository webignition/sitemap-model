<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use Mockery;
use Mockery\Mock;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use webignition\WebResource\WebResource;

class ResponseFactory
{
    const CONTENT_TYPE_ATOM = 'application/atom+xml';
    const CONTENT_TYPE_RSS = 'application/rss+xml';
    const CONTENT_TYPE_XML = 'text/xml';
    const CONTENT_TYPE_TXT = 'text/plain';
    const CONTENT_TYPE_HTML = 'text/html';

    /**
     * @param string $content
     * @param string $contentType
     *
     * @return Mock|ResponseInterface
     */
    public static function create($content, $contentType)
    {
        /* @var ResponseInterface|Mock $response */
        $response = Mockery::mock(ResponseInterface::class);

        $response
            ->shouldReceive('getHeader')
            ->once()
            ->with(WebResource::HEADER_CONTENT_TYPE)
            ->andReturn([
                $contentType,
            ]);

        /* @var StreamInterface|Mock $bodyStream */
        $bodyStream = Mockery::mock(StreamInterface::class);
        $bodyStream
            ->shouldReceive('__toString')
            ->once()
            ->withNoArgs()
            ->andReturn($content);

        $response
            ->shouldReceive('getBody')
            ->once()
            ->withNoArgs()
            ->andReturn($bodyStream);

        return $response;
    }
}
