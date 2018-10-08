<?php

namespace webignition\WebResource\Sitemap\Tests;

use webignition\WebResource\Sitemap\Tests\Services\SitemapFactory;
use webignition\WebResource\TestingTools\FixtureLoader;

class GetUrlsFromChildrenTest extends \PHPUnit\Framework\TestCase
{
    public function testGettingUrlsFromChildren()
    {
        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';

        $sitemap = SitemapFactory::createXmlIndexSitemap();

        $childSitemap1 = SitemapFactory::createXmlSitemap(FixtureLoader::load('example.com.sitemap.01.xml'));
        $childSitemap2 = SitemapFactory::createXmlSitemap(FixtureLoader::load('example.com.sitemap.02.xml'));
        $childSitemap3 = SitemapFactory::createXmlSitemap(FixtureLoader::load('example.com.sitemap.03.xml'));

        $sitemap->addChild($childSitemap1);
        $sitemap->addChild($childSitemap2);
        $sitemap->addChild($childSitemap3);

        $urls = [];
        foreach ($sitemap->getChildren() as $childSitemap) {
            $urls = array_merge($urls, $childSitemap->getUrls());
        }

        $this->assertCount(9, $urls);
    }
}
