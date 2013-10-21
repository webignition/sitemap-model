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
     * Child sitemaps; a collection of Sitemap objects for index sitemaps, an
     * empty collection for non-index sitemaps
     * 
     * @var array
     */
    private $children = array();
    
    
    /**
     *
     * @var array Collection of URLs found in this sitemap
     */
    private $urls = null;
    
    
    /**
     * 
     * @param SitemapConfiguration $configuration
     */
    public function setConfiguration(SitemapConfiguration $configuration) {
        $this->configuration = $configuration;
    } 
    
    
    /**
     * 
     * @return SitemapConfiguration
     */
    public function getConfiguration() {
        return $this->configuration;
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
        if (is_null($this->urls)) {
            $this->urls = array();
            
            $extractorClass = $this->configuration->getExtractorClassForType($this->getType());
            if (is_null($extractorClass)) {            
                return array();
            }        

            $extractor = new $extractorClass;
            $urls = $extractor->extract($this->getContent());

            foreach ($urls as $url) {
                $normalisedUrl = (string)new NormalisedUrl($url);            
                if (!array_key_exists($normalisedUrl, $this->urls)) {
                    $this->urls[$normalisedUrl] = true;
                }
            }           
        }
        
        return array_keys($this->urls);
    }
    
    
    /**
     * 
     * @param \webignition\WebResource\Sitemap\Sitemap $sitemap
     * @return boolean
     */
    public function addChild(Sitemap $sitemap) {
        if (!$this->isIndex()) {
            return false;
        }
        
        $childUrl = new \webignition\NormalisedUrl\NormalisedUrl($sitemap->getUrl());
        $childIndex = md5((string)$childUrl);
        
        $this->children[$childIndex] = $sitemap;
        return true;
    }
    
    
    /**
     * 
     * @return array
     */
    public function getChildren() {
        return $this->children;
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