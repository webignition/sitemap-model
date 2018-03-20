<?php

namespace webignition\Tests\WebResource\Sitemap;

use Psr\Http\Message\ResponseInterface;
use webignition\Tests\WebResource\Sitemap\Factory\ResponseFactory;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\TypeInterface;

class SitemapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider createDataProvider
     *
     * @param ResponseInterface $response
     * @param string $type
     * @param string $expectedType
     * @param bool $expectedIsIndex
     * @param bool $expectedIsSitemap
     */
    public function testCreate(ResponseInterface $response, $type, $expectedType, $expectedIsIndex, $expectedIsSitemap)
    {
        $sitemap = new Sitemap($response);

        $sitemap->setType($type);

        $this->assertEquals($expectedType, $sitemap->getType());
        $this->assertEquals($expectedIsIndex, $sitemap->isIndex());
        $this->assertEquals($expectedIsSitemap, $sitemap->isSitemap());
    }

    /**
     * @return array
     */
    public function createDataProvider()
    {
        return [
            'not a sitemap' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_TXT, ''),
                'type' => null,
                'expectedType' => null,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => false,
            ],
            'text/plain' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_TXT, ''),
                'type' => TypeInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedType' => TypeInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'xml default' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_XML, ''),
                'type' => TypeInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedType' => TypeInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'xml index' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_XML, ''),
                'type' => TypeInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedType' => TypeInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedIsIndex' => true,
                'expectedIsSitemap' => true,
            ],
            'atom' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_ATOM, ''),
                'type' => TypeInterface::TYPE_ATOM,
                'expectedType' => TypeInterface::TYPE_ATOM,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'rss' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_RSS, ''),
                'type' => TypeInterface::TYPE_RSS,
                'expectedType' => TypeInterface::TYPE_RSS,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
        ];
    }
}
