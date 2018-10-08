<?php

namespace webignition\WebResource\Sitemap\Tests\Services;

use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use webignition\WebResource\Sitemap\Sitemap;

class ResponseFactory extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $content
     * @param string $contentType
     *
     * @return MockInterface|ResponseInterface
     */
    public static function create(string $content, string $contentType)
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
