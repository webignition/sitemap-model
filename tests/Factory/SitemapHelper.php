<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Sitemap;

class SitemapHelper
{
    /**
     * @param string|null $url
     *
     * @return Sitemap
     */
    public static function createXmlIndexSitemap($url = null)
    {
        $response = ResponseFactory::create(
            FixtureLoader::load(FixtureLoader::SITEMAP_XML_INDEX_CONTENT),
            ResponseFactory::CONTENT_TYPE_XML
        );

        $factory = new Factory();

        return $factory->create($response, $url);
    }

    /**
     * @param string $fixtureName
     * @param string|null $url
     *
     * @return Sitemap
     */
    public static function createXmlSitemap($fixtureName, $url = null)
    {
        $response = ResponseFactory::create(
            FixtureLoader::load($fixtureName),
            ResponseFactory::CONTENT_TYPE_XML
        );

        $factory = new Factory();

        return $factory->create($response, $url);
    }
}
