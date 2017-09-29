<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\WebResource\Sitemap\Sitemap;

class IsSitemapTest extends BaseTest
{
    protected function setUp()
    {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }

    public function testIsSitemapForAtomFeed()
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('AtomContent', 'application/atom+xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');

        $this->assertTrue($sitemap->isSitemap());
    }

    public function testisIndexForRssFeed()
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('RssContent', 'application/rss+xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');

        $this->assertTrue($sitemap->isSitemap());
    }

    public function testIsSitemapForSitemapIndexType()
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent', 'application/xml'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $this->assertTrue($sitemap->isSitemap());
    }

    public function testIsSitemapForSitemapsOrgTxtSitemapType()
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgTxtContent', 'text/plain'));
        $sitemap->setUrl('http://webignition.net/sitemap.txt');

        $this->assertTrue($sitemap->isSitemap());
    }

    public function testIsSitemapForSitemapsOrgXmlSitemapType()
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlContent', 'application/xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertTrue($sitemap->isSitemap());
    }

    public function testIsSitemapForNonSitemapContent()
    {
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture());
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertFalse($sitemap->isSitemap());

        $sitemap->setContent("one\ntwo\nthree");
        $this->assertFalse($sitemap->isSitemap());

        $sitemap->setContent("<!DOCTYPE html>
<html>
  <head>
    <title>Hello HTML</title>
  </head>
  <body>
    <p>Hello World!</p>
  </body>
</html>");
        $this->assertFalse($sitemap->isSitemap());
    }
}
