<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use Mockery\Mock;
use Psr\Http\Message\UriInterface;

class UriFactory
{
    /**
     * @param string $uriString
     *
     * @return UriInterface|Mock
     */
    public static function create($uriString = null)
    {
        /* @var UriInterface|Mock $uri */
        $uri = \Mockery::mock(UriInterface::class);

        return $uri;
    }
}
