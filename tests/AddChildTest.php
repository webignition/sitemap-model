<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\WebResource\Sitemap\Sitemap;

class AddChildTest extends BaseTest
{
    protected function setUp()
    {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }

    public function testAddChildToNonIndexSitemap()
    {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlContent'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');

        $this->assertFalse($sitemap->addChild(new Sitemap()));
    }

    public function testAddChildToIndexSitemap()
    {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $childSitemap = $this->createSitemap();
        $childSitemap->setHttpResponse($this->getHttpFixture());
        $childSitemap->setUrl('http://www.example.com/sitemap1.xml');

        $this->assertTrue($sitemap->addChild($childSitemap));
    }

    public function testAddingChildIsIdempotent()
    {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $childSitemap = $this->createSitemap();
        $childSitemap->setHttpResponse($this->getHttpFixture());
        $childSitemap->setUrl('http://www.example.com/sitemap1.xml');

        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertEquals(1, count($sitemap->getChildren()));

        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertEquals(1, count($sitemap->getChildren()));
    }

    public function testAddingMultipleChildren()
    {
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');

        $childSitemap1 = $this->createSitemap();
        $childSitemap1->setHttpResponse($this->getHttpFixture());
        $childSitemap1->setUrl('http://www.example.com/sitemap1.xml');

        $childSitemap2 = $this->createSitemap();
        $childSitemap2->setHttpResponse($this->getHttpFixture());
        $childSitemap2->setUrl('http://www.example.com/sitemap2.xml');

        $childSitemap3 = $this->createSitemap();
        $childSitemap3->setHttpResponse($this->getHttpFixture());
        $childSitemap3->setUrl('http://www.example.com/sitemap3.xml');

        $this->assertTrue($sitemap->addChild($childSitemap1));
        $this->assertTrue($sitemap->addChild($childSitemap2));
        $this->assertTrue($sitemap->addChild($childSitemap3));
        $this->assertEquals(3, count($sitemap->getChildren()));
    }
}
