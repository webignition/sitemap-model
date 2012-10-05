<?php

use webignition\WebResource\Sitemap\Sitemap;

class GetTypeTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }      

    public function testGetAtomFeedType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');
        $sitemap->setContent($this->getFixture('AtomContent'));
        $sitemap->setContentType('application/atom+xml');
        
        $this->assertEquals('application/atom+xml', $sitemap->getType());
    }
    
    
    public function testGetRssFeedType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');
        $sitemap->setContent($this->getFixture('RssContent'));
        $sitemap->setContentType('application/rss+xml');
        
        $this->assertEquals('application/rss+xml', $sitemap->getType());
    }
    
    public function testGetSitemapIndexType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgSitemapIndexContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertEquals('sitemaps.org.xml.index', $sitemap->getType());
    }
    
    public function testGetSitemapsOrgTxtSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.txt');
        $sitemap->setContent($this->getFixture('SitemapsOrgTxtContent'));
        $sitemap->setContentType('text/plain');
        
        $this->assertEquals('sitemaps.org.txt', $sitemap->getType());
    }
    
    public function testGetSitemapsOrgXmlSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlContent'));
        $sitemap->setContentType('application/xml');
        
        $this->assertEquals('sitemaps.org.xml', $sitemap->getType());
    }    
}
