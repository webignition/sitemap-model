<?php

use webignition\WebResource\Sitemap\Sitemap;

class IsIndexTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }      

    public function testIsIndexForAtomFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');
        $sitemap->setContent($this->getFixture('AtomContent'));
        $sitemap->setContentType('application/atom+xml');
        
        $this->assertFalse($sitemap->isIndex());
    }    
    
    public function testisIndexForRssFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');
        $sitemap->setContent($this->getFixture('RssContent'));
        $sitemap->setContentType('application/rss+xml');
        
        $this->assertFalse($sitemap->isIndex());
    }
    
    public function testIsIndexForSitemapIndexType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertTrue($sitemap->isIndex());
    }
    
    public function testIsIndexForSitemapsOrgTxtSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.txt');
        $sitemap->setContent($this->getFixture('SitemapsOrgTxtContent'));
        $sitemap->setContentType('text/plain');
        
        $this->assertFalse($sitemap->isIndex());
    }
    
    public function testIsIndexForSitemapsOrgXmlSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertFalse($sitemap->isIndex());
    }    
}
