<?php

use webignition\WebResource\Sitemap\Sitemap;

class GetSitemapUrlsTeset extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }      

    public function testGetSitemapUrlsForAtomFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');
        $sitemap->setContent($this->getFixture('AtomContent'));
        $sitemap->setContentType('application/atom+xml');
        
        $this->assertEquals(0, count($sitemap->getSitemapUrls()));
        
    }    
    
    public function testisIndexForRssFeed() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');
        $sitemap->setContent($this->getFixture('RssContent'));
        $sitemap->setContentType('application/rss+xml');
        
        $this->assertEquals(0, count($sitemap->getSitemapUrls()));
    }
    
    public function testGetSitemapUrlsForSitemapIndexType() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertEquals(3, count($sitemap->getSitemapUrls()));
    }
    
    public function testGetSitemapUrlsForSitemapsOrgTxtSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.txt');
        $sitemap->setContent($this->getFixture('SitemapsOrgTxtContent'));
        $sitemap->setContentType('text/plain');
        
        $this->assertEquals(0, count($sitemap->getSitemapUrls()));
    }
    
    public function testGetSitemapUrlsForSitemapsOrgXmlSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertEquals(0, count($sitemap->getSitemapUrls()));
    }    
}
