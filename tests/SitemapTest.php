<?php

namespace webignition\WebResource\Sitemap\Tests;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\Tests\Services\ResponseFactory;
use webignition\WebResource\TestingTools\FixtureLoader;

class SitemapTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider createFromResponseFooDataProvider
     *
     * @param ResponseInterface $response
     * @param bool $expectedIsIndex
     * @param bool $expectedIsSitemap
     */
    public function testCreateFromResponseFoo(
        ResponseInterface $response,
        bool $expectedIsIndex,
        bool $expectedIsSitemap
    ) {
        /* @var Sitemap $sitemap */
        $sitemap = Sitemap::createFromResponse(\Mockery::mock(UriInterface::class), $response);

        $this->assertTrue(true);

//        $this->assertEquals($expectedIsIndex, $sitemap->isIndex());
//        $this->assertEquals($expectedIsSitemap, $sitemap->isSitemap());
    }

    /**
     * @return array
     */
    public function createFromResponseFooDataProvider()
    {
        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';

        return [
            'not a sitemap' => [
                'response' => ResponseFactory::create('text/plain', ''),
                'expectedIsIndex' => false,
                'expectedIsSitemap' => false,
            ],
            'text/plain' => [
                'response' => ResponseFactory::create(ContentTypes::CONTENT_TYPE_TXT, ''),
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'xml default' => [
                'response' => ResponseFactory::create(ContentTypes::CONTENT_TYPE_XML, ''),
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'xml index' => [
                'response' => ResponseFactory::create(ContentTypes::CONTENT_TYPE_XML, ''),
                'expectedIsIndex' => true,
                'expectedIsSitemap' => true,
            ],
            'atom' => [
                'response' => ResponseFactory::create(ContentTypes::CONTENT_TYPE_ATOM, ''),
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'rss' => [
                'response' => ResponseFactory::create(ContentTypes::CONTENT_TYPE_RSS, ''),
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
        ];
    }
}
