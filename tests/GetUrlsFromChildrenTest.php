<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\SitemapHelper;

class GetUrlsFromChildrenTest extends \PHPUnit_Framework_TestCase
{
    public function testGettingUrlsFromChildren()
    {
        $sitemap = SitemapHelper::createXmlIndexSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $childSitemap1 = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_EXAMPLE_1);
        $childSitemap2 = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_EXAMPLE_2);
        $childSitemap3 = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_EXAMPLE_3);

        $childSitemap1->setUrl('http://example.com/sitemap1.xml');
        $childSitemap2->setUrl('http://example.com/sitemap2.xml');
        $childSitemap3->setUrl('http://example.com/sitemap3.xml');

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
