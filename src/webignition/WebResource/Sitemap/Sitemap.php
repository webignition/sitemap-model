<?php
namespace webignition\WebResource\Sitemap;

use webignition\WebResource\WebResource;
use webignition\WebResource\Sitemap\Identifier\Identifier;
use webignition\WebsiteSitemapUrlRetriever\WebsiteSitemapUrlRetriever;

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
     * @var WebsiteSitemapUrlRetriever
     */
    private $urlRetriever = null;
    
       
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
        return $this->getUrlRetiever()->getUrls($this);
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
    
    
    private function getUrlRetiever() {
        if (is_null($this->urlRetriever)) {
            $this->urlRetriever = new WebsiteSitemapUrlRetriever();
            $configuration = new \webignition\WebsiteSitemapUrlRetriever\Configuration();
            $configuration->setSitemapTypeToUrlExtractorClassMap(array(
                'sitemaps.org.xml' => 'webignition\WebsiteSitemapUrlRetriever\UrlExtractor\SitemapsOrgXmlUrlExtractor',
                'sitemaps.org.txt' => 'webignition\WebsiteSitemapUrlRetriever\UrlExtractor\SitemapsOrgTxtUrlExtractor',
                'application/atom+xml' => 'webignition\WebsiteSitemapUrlRetriever\UrlExtractor\NewsFeedUrlExtractor',
                'application/rss+xml' => 'webignition\WebsiteSitemapUrlRetriever\UrlExtractor\NewsFeedUrlExtractor'
            ));
            
            $this->urlRetriever->setConfiguration($configuration);         
            
        }
        
        return $this->urlRetriever;
    }
    
}