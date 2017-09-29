<?php

namespace webignition\Tests\WebResource\Sitemap;

class GetUrlsTest extends BaseTest {

    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }

    public function testGetSitemapsOrgXmlUrls() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlContent'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertEquals(10, count($sitemap->getUrls()));
    }

    public function testGetSitemapsOrgTxtUrls() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgTxtContent'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertEquals(3, count($sitemap->getUrls()));
    }

    public function testAtomUrls() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('AtomContent'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertEquals(1, count($sitemap->getUrls()));
    }

    public function testRssUrls() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('RssContent'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertEquals(1, count($sitemap->getUrls()));
    }

    public function testGetSitemapsOrgXmlIndexUrls() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $this->assertEquals(3, count($sitemap->getUrls()));
    }


    public function testGetParentLocationUrlsOnly() {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlWithImages.xml'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $this->assertEquals(18, count($sitemap->getUrls()));
    }
}
