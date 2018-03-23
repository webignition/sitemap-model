<?php

namespace webignition\Tests\WebResource\Sitemap;

use Psr\Http\Message\ResponseInterface;
use webignition\InternetMediaType\Parser\ParseException as InternetMediaTypeParseException;
use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\TestingTools\FixtureLoader;
use webignition\WebResource\TestingTools\ResponseFactory;
use webignition\WebResourceInterfaces\SitemapInterface;

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
     *
     * @throws InternetMediaTypeParseException
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
        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';

        return [
            'not a sitemap' => [
                'response' => ResponseFactory::create('text/plain', ''),
                'type' => null,
                'expectedType' => null,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => false,
            ],
            'text/plain' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_TXT, ''),
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'xml default' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_XML, ''),
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_XML,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'xml index' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_XML, ''),
                'type' => SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedType' => SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
                'expectedIsIndex' => true,
                'expectedIsSitemap' => true,
            ],
            'atom' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_ATOM, ''),
                'type' => SitemapInterface::TYPE_ATOM,
                'expectedType' => SitemapInterface::TYPE_ATOM,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
            'rss' => [
                'response' => ResponseFactory::create(ResponseFactory::CONTENT_TYPE_RSS, ''),
                'type' => SitemapInterface::TYPE_RSS,
                'expectedType' => SitemapInterface::TYPE_RSS,
                'expectedIsIndex' => false,
                'expectedIsSitemap' => true,
            ],
        ];
    }
}
