<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Sitemap;

class SitemapHelper
{
    /**
     * @return Sitemap
     */
    public static function createXmlIndexSitemap()
    {
        $httpResponse = HttpResponseFactory::create(
            FixtureLoader::load(FixtureLoader::SITEMAP_XML_INDEX_CONTENT),
            HttpResponseFactory::CONTENT_TYPE_XML
        );

        $factory = new Factory();

        return $factory->create($httpResponse);
    }

    /**
     * @param string $fixtureName
     *
     * @return Sitemap
     */
    public static function createXmlSitemap($fixtureName)
    {
        $httpResponse = HttpResponseFactory::create(
            FixtureLoader::load($fixtureName),
            HttpResponseFactory::CONTENT_TYPE_XML
        );

        $factory = new Factory();

        return $factory->create($httpResponse);
    }
}
