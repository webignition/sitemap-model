<?php

use webignition\WebResource\Sitemap\Sitemap;

class AddChildTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }
    
    public function testAddChildToNonIndexSitemap() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlContent'));
        
        $this->assertFalse($sitemap->addChild(new Sitemap()));
    }  
    
    public function testAddChildToIndexSitemap() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgSitemapIndexContent'));
        
        $childSitemap = $this->createSitemap();
        $childSitemap->setUrl('http://www.example.com/sitemap1.xml');
        
        $this->assertTrue($sitemap->addChild($childSitemap));        
    }     
}
