<?php

class GetUrlsTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }
    
    public function testGetSitemapsOrgXmlUrls() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlContent'));
        
        $this->assertEquals(10, count($sitemap->getUrls()));        
    }    
    
    public function testGetSitemapsOrgTxtUrls() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgTxtContent'));
        
        $this->assertEquals(3, count($sitemap->getUrls()));        
    }      
    
    public function testAtomUrls() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('AtomContent'));
        
        $this->assertEquals(1, count($sitemap->getUrls()));        
    }     
    
    public function testRssUrls() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('RssContent'));
        
        $this->assertEquals(1, count($sitemap->getUrls()));        
    }     
}
