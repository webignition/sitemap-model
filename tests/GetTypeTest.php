<?php

use webignition\WebResource\Sitemap\Sitemap;

class GetTypeTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }      

    public function testGetAtomFeedType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('AtomContent', 'application/atom+xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.atom.xml');        
        
        $this->assertEquals('application/atom+xml', $sitemap->getType());
    }
    
    
    public function testGetRssFeedType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('RssContent'), 'application/rss+xml');
        $sitemap->setUrl('http://webignition.net/sitemap.rss.xml');        

        $this->assertEquals('application/rss+xml', $sitemap->getType());
    }
    
    public function testGetSitemapIndexType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgSitemapIndexContent', 'application/xml'));
        $sitemap->setUrl('http://webignition.net/sitemap_index.xml');
        
        $this->assertEquals('sitemaps.org.xml.index', $sitemap->getType());
    }
    
    public function testGetSitemapsOrgTxtSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgTxtContent', 'text/plain'));
        $sitemap->setUrl('http://webignition.net/sitemap.txt');

        $this->assertEquals('sitemaps.org.txt', $sitemap->getType());
    }
    
    public function testGetSitemapsOrgXmlSitemapType() {        
        $sitemap = new Sitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlContent', 'application/xml'));
        $sitemap->setUrl('http://webignition.net/sitemap.xml');
        
        $this->assertEquals('sitemaps.org.xml', $sitemap->getType());
    }    
}
