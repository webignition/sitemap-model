<?php
namespace webignition\WebResource\Sitemap;

use webignition\WebResource\WebResource;
use webignition\WebResource\Sitemap\Identifier\Identifier;
use webignition\WebResource\Sitemap\Configuration as SitemapConfiguration;
use webignition\NormalisedUrl\NormalisedUrl;

/**
 * 
 */
class Sitemap extends WebResource
{
    const SITEMAP_INDEX_TYPE = 'sitemaps.org.xml.index';
    
    /**
     *
     * @var string
     */
    private $type = null;
    
    
    /**
     *
     * @var WebsiteSitemapIdentifier
     */
    private $identifier = null;
    
    
    /**
     *
     * @var Configuration
     */
    private $configuration = null;
    
    
    /**
     * 
     * @param SitemapConfiguration $configuration
     */
    public function setConfiguration(SitemapConfiguration $configuration) {
        $this->configuration = $configuration;
    }    
    
       
    /**
     * 
     * @return string
     */
    public function getType() {
        if (is_null($this->type)) {
            $this->type = $this->getIdentifier()->getType($this->getContent());
        }
        
        return $this->type;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isIndex() {
        return $this->getType() == self::SITEMAP_INDEX_TYPE;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isSitemap() {        
        return !is_null($this->getType());
    }
    
    
    /**
     * 
     * @return array
     */
    public function getUrls() {         
        if (!$this->isIndex()) {
            return $this->getDirectUrls();
        }
        
        return array();
    }
    
    
    private function getDirectUrls() {
        $extractorClass = $this->configuration->getExtractorClassForType($this->getType());
        if (is_null($extractorClass)) {            
            return array();
        }        
        
        $extractor = new $extractorClass;
        $urls = $extractor->extract($this->getContent());
        
        $uniqueUrls = array();
        
        foreach ($urls as $url) {
            $normalisedUrl = new NormalisedUrl($url);
            if (!in_array((string)$normalisedUrl, $uniqueUrls)) {
                $uniqueUrls[] = (string)$normalisedUrl;
            }
        }        
        
        return $uniqueUrls;        
    }
    
    
    /**
     * Get collection of URLs to sitemaps referenced within
     * Relevant only to sitemap indexes, non-index sitemaps will always
     * return an empty collection
     * 
     * @return array
     */
    public function getSitemapUrls() {
        if (!$this->isIndex()) {
            return array();
        }
        
        return $this->getDirectUrls();
    }
    
    
    /**
     * 
     * @return Identifier
     */
    private function getIdentifier() {
        if (is_null($this->identifier)) {
            $this->identifier = new Identifier();    
            
            $sitemapsOrgXmlMatcher = new \webignition\WebResource\Sitemap\Identifier\Matcher\SitemapsOrgXml();
            $sitemapsOrgXmlMatcher->setType('sitemaps.org.xml');            
            $this->identifier->addMatcher($sitemapsOrgXmlMatcher);
            
            $sitemapsOrgTxtMatcher = new \webignition\WebResource\Sitemap\Identifier\Matcher\SitemapsOrgTxt();
            $sitemapsOrgTxtMatcher->setType('sitemaps.org.txt');            
            $this->identifier->addMatcher($sitemapsOrgTxtMatcher);            
            
            $rssFeedMatcher = new \webignition\WebResource\Sitemap\Identifier\Matcher\RssFeed();
            $rssFeedMatcher->setType('application/rss+xml');            
            $this->identifier->addMatcher($rssFeedMatcher);   
            
            $atomFeedMatcher = new \webignition\WebResource\Sitemap\Identifier\Matcher\AtomFeed();
            $atomFeedMatcher->setType('application/atom+xml');                        
            $this->identifier->addMatcher($atomFeedMatcher);
            
            $sitemapsOrgXmlIndexMatcher = new \webignition\WebResource\Sitemap\Identifier\Matcher\SitemapsOrgXmlIndex();
            $sitemapsOrgXmlIndexMatcher->setType('sitemaps.org.xml.index');                        
            $this->identifier->addMatcher($sitemapsOrgXmlIndexMatcher);            
        }
        
        return $this->identifier;
    }
    
}