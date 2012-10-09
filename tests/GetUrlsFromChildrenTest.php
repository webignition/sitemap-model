<?php

class GetUrlsFromChildrenTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }   
    
    
    public function testGettingUrlsFromChildren() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgSitemapIndexContent'));
        
        $childSitemap1 = $this->createSitemap();
        $childSitemap1->setUrl('http://www.example.com/sitemap1.xml');
        $childSitemap1->setContent($this->getFixture('example.com.sitemap.01.xml'));
        
        $childSitemap2 = $this->createSitemap();
        $childSitemap2->setUrl('http://www.example.com/sitemap2.xml');
        $childSitemap2->setContent($this->getFixture('example.com.sitemap.02.xml'));
        
        $childSitemap3 = $this->createSitemap();
        $childSitemap3->setUrl('http://www.example.com/sitemap3.xml');        
        $childSitemap3->setContent($this->getFixture('example.com.sitemap.03.xml'));
        
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
