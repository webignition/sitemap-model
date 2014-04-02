<?php

use webignition\WebResource\Sitemap\Sitemap;

class ParsePerformanceTest extends BaseTest {
    
    public function setUp() {
        $this->setTestFixturePath(__CLASS__, $this->getName());
    }
    
    public function testParseSomewhatVeryLargeSitemap() {        
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlWith8497Urls.xml'));
        $sitemap->setUrl('http://example.com/sitemap.xml');        
        
        $this->assertEquals(8497, count($sitemap->getUrls()));
    }      
    
    public function testParseInvalidXmlSitemap() {        
        $sitemap = $this->createSitemap();
        $sitemap->setHttpResponse($this->getHttpFixture('SitemapsOrgXmlInvalid.xml'));
        $sitemap->setUrl('http://example.com/sitemap.xml');        
        
        $this->assertEquals(0, count($sitemap->getUrls()));
    }      
}
