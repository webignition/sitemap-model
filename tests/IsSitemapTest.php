<?php

use webignition\WebResource\Sitemap\Sitemap;

class IsSitemapTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }      

    public function testIsSitemapForAtomFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');
        $sitemap->setContent($this->getFixture('AtomContent'));
        $sitemap->setContentType('application/atom+xml');
        
        $this->assertTrue($sitemap->isSitemap());
    }    
    
    public function testisIndexForRssFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');
        $sitemap->setContent($this->getFixture('RssContent'));
        $sitemap->setContentType('application/rss+xml');
        
        $this->assertTrue($sitemap->isSitemap());
    }
    
    public function testIsSitemapForSitemapIndexType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertTrue($sitemap->isSitemap());
    }
    
    public function testIsSitemapForSitemapsOrgTxtSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.txt');
        $sitemap->setContent($this->getFixture('SitemapsOrgTxtContent'));
        $sitemap->setContentType('text/plain');
        
        $this->assertTrue($sitemap->isSitemap());
    }
    
    public function testIsSitemapForSitemapsOrgXmlSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertTrue($sitemap->isSitemap());
    }
    
    public function testIsSitemapForNonSitemapContent() {
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        
        $sitemap->setContent("");        
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
