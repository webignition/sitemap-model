<?php

use webignition\WebResource\Sitemap\Sitemap;

class ParsePerformanceTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }
    
    public function testAddChildToNonIndexSitemap() {        
        $sitemap = $this->createSitemap();
        $sitemap->setUrl('http://example.com/sitemap.xml');
        $sitemap->setContent($this->getFixture('SitemapsOrgXmlWith8497Urls.xml'));
        
        $this->assertEquals(8497, count($sitemap->getUrls()));
    }      
}
