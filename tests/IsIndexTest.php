<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\HttpResponseFactory;
use webignition\WebResource\Sitemap\Factory;

class IsIndexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider isIndexDataProvider
     *
     * @param string $fixtureName
     * @param string $contentType
     * @param bool $expectedIsIndex
     */
    public function testIsIndex($fixtureName, $contentType, $expectedIsIndex)
    {
        $factory = new Factory();

        $fixture = FixtureLoader::load($fixtureName);
        $httpResponse = HttpResponseFactory::create($fixture, $contentType);

        $sitemap = $factory->create($httpResponse);

        $this->assertEquals($expectedIsIndex, $sitemap->isIndex());
    }

    /**
     * @return array
     */
    public function isIndexDataProvider()
    {
        return [
            'atom' => [
                'fixtureName' => FixtureLoader::ATOM_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_ATOM,
                'expectedIsIndex' => false,
            ],
            'rss' => [
                'fixtureName' => FixtureLoader::RSS_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_RSS,
                'expectedIsIndex' => false,
            ],
            'sitemaps org xml' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedIsIndex' => false,
            ],
            'sitemaps org txt' => [
                'fixtureName' => FixtureLoader::SITEMAP_TXT_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_TXT,
                'expectedIsIndex' => false,
            ],
            'sitemaps org xml index' => [
                'fixtureName' => FixtureLoader::SITEMAP_XML_INDEX_CONTENT,
                'contentType' => HttpResponseFactory::CONTENT_TYPE_XML,
                'expectedIsIndex' => true,
            ],
        ];
    }
}
