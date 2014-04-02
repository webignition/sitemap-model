<?php

use webignition\WebResource\Sitemap\Sitemap;

class IsIndexTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }      

    public function testIsIndexForAtomFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('AtomContent', 'application/atom+xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');
        
        $this->assertFalse($sitemap->isIndex());
    }    
    
    public function testisIndexForRssFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('RssContent', 'application/rss+xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');        
        
        $this->assertFalse($sitemap->isIndex());
    }
    
    public function testIsIndexForSitemapIndexType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent', 'application/xml'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');        

        $this->assertTrue($sitemap->isIndex());
    }
    
    public function testIsIndexForSitemapsOrgTxtSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgTxtContent', 'text/plain'));
        $sitemap->setUrl('http://webignition.net/sitemap.txt');        
        
        $this->assertFalse($sitemap->isIndex());
    }
    
    public function testIsIndexForSitemapsOrgXmlSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlContent', 'application/xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');         
        
        $this->assertFalse($sitemap->isIndex());
    }    
}
