<?php

namespace webignition\Tests\WebResource\Sitemap;

class GetUrlsFromChildrenTest extends BaseTest {

    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }


    public function testGettingUrlsFromChildren() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $childSitemap1 = $this->createSitemap();
        $childSitemap1->setHttpResponse($this->getHttpFixture('example.com.sitemap.01.xml'));
        $childSitemap1->setUrl('http://www.example.com/sitemap1.xml');

        $childSitemap2 = $this->createSitemap();
        $childSitemap2->setHttpResponse($this->getHttpFixture('example.com.sitemap.02.xml'));
        $childSitemap2->setUrl('http://www.example.com/sitemap2.xml');

        $childSitemap3 = $this->createSitemap();
        $childSitemap3->setHttpResponse($this->getHttpFixture('example.com.sitemap.03.xml'));
        $childSitemap3->setUrl('http://www.example.com/sitemap3.xml');

        $this->assertTrue($sitemap->addChild($childSitemap1));
        $this->assertTrue($sitemap->addChild($childSitemap2));
        $this->assertTrue($sitemap->addChild($childSitemap3));
        $this->assertEquals(3, count($sitemap->getChildren()));

        $urls = array();
        foreach ($sitemap->getChildren() as $childSitemap) {
            $urls = array_merge($urls, $childSitemap->getUrls());
        }

        $this->assertEquals(30, count($urls));
    }
}
