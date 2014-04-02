<?php

use webignition\WebResource\Sitemap\Sitemap;
use webignition\WebResource\Sitemap\Configuration as SitemapConfiguration;

abstract class BaseTest extends PHPUnit_Framework_TestCase {  
    
    const FIXTURES_BASE_PATH = '/fixtures';
    
    /**
     *
     * @var string
     */
    private $fixturePath = null;    

    /**
     * 
     * @param string $testClass
     * @param string $testMethod
     */
    protected function setTestFixturePath($testClass, $testMethod) {
        $this->fixturePath = __DIR__ . self::FIXTURES_BASE_PATH . '/' . $testClass . '/' . $testMethod;       
    }    
    
    
    /**
     * 
     * @return string
     */
    protected function getTestFixturePath() {
        return $this->fixturePath;     
    }
    
    
    /**
     * 
     * @param string $fixtureName
     * @return string
     */
    private function getFixture($fixtureName) {
        if (file_exists($this->getTestFixturePath() . '/' . $fixtureName)) {
            return file_get_contents($this->getTestFixturePath() . '/' . $fixtureName);
        }
        
        return file_get_contents(__DIR__ . self::FIXTURES_BASE_PATH . '/Common/' . $fixtureName);        
    }
    
    
    /**
     * 
     * @param string $fixtureName
     * @return \Guzzle\Http\Message\Response
     */
    protected function getHttpFixture($fixtureName = '', $contentType = 'application/xml') {
        $message = "HTTP/1.0 200 OK\nContent-Type:" . $contentType . "\n\n";
        
        if ($fixtureName != '') {
            $message .= $this->getFixture($fixtureName);
        }        
        
        return \Guzzle\Http\Message\Response::fromMessage($message);
    }    
//    
//    /**
//     * 
//     * @return \Guzzle\Http\Message\Response
//     */
//    protected function getEmptyHttpFixture() {
//        return \Guzzle\Http\Message\Response::fromMessage("HTTP/1.0 200 OK\nContent-Type:application/xml");        
//    }
    
    
    protected function createSitemap() {
        $configuration = new SitemapConfiguration;
        $configuration->setTypeToUrlExtractorClassMap(array(
            'sitemaps.org.xml' => 'webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlUrlExtractor',
            'sitemaps.org.txt' => 'webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgTxtUrlExtractor',
            'application/atom+xml' => 'webignition\WebResource\Sitemap\UrlExtractor\NewsFeedUrlExtractor',
            'application/rss+xml' => 'webignition\WebResource\Sitemap\UrlExtractor\NewsFeedUrlExtractor',
            'sitemaps.org.xml.index' => 'webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlIndexUrlExtractor'
        ));

        $sitemap = new Sitemap();
        $sitemap->setConfiguration($configuration);
        return $sitemap;
    }
    
    
}