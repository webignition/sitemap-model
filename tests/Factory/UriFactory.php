<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use Mockery\MockInterface;
use Psr\Http\Message\UriInterface;

class UriFactory
{
    /**
     * @return UriInterface|MockInterface
     */
    public static function create()
    {
        /* @var UriInterface|MockInterface $uri */
        $uri = \Mockery::mock(UriInterface::class);

        return $uri;
    }
}
