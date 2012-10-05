<?php
namespace webignition\WebResource\Sitemap;

use webignition\WebResource\WebResource;
use webignition\WebsiteSitemapIdentifier\WebsiteSitemapIdentifier;

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
    private $sitemapIdentifier = null;
    
       
    /**
     * 
     * @return string
     */
    public function getType() {
        if (is_null($this->type)) {
            $this->type = $this->getSitemapIdentifier()->getType($this->getContent());
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
     * @return WebsiteSitemapIdentifier
     */
    private function getSitemapIdentifier() {
        if (is_null($this->sitemapIdentifier)) {
            $this->sitemapIdentifier = new WebsiteSitemapIdentifier();    
            
            $sitemapsOrgXmlMatcher = new \webignition\WebsiteSitemapIdentifier\SitemapMatcher\SitemapsOrgXml();
            $sitemapsOrgXmlMatcher->setType('sitemaps.org.xml');            
            $this->sitemapIdentifier->addMatcher($sitemapsOrgXmlMatcher);
            
            $sitemapsOrgTxtMatcher = new \webignition\WebsiteSitemapIdentifier\SitemapMatcher\SitemapsOrgTxt();
            $sitemapsOrgTxtMatcher->setType('sitemaps.org.txt');            
            $this->sitemapIdentifier->addMatcher($sitemapsOrgTxtMatcher);            
            
            $rssFeedMatcher = new \webignition\WebsiteSitemapIdentifier\SitemapMatcher\RssFeed();
            $rssFeedMatcher->setType('application/rss+xml');            
            $this->sitemapIdentifier->addMatcher($rssFeedMatcher);   
            
            $atomFeedMatcher = new \webignition\WebsiteSitemapIdentifier\SitemapMatcher\AtomFeed();
            $atomFeedMatcher->setType('application/atom+xml');                        
            $this->sitemapIdentifier->addMatcher($atomFeedMatcher);
            
            $sitemapsOrgXmlIndexMatcher = new \webignition\WebsiteSitemapIdentifier\SitemapMatcher\SitemapsOrgXmlIndex();
            $sitemapsOrgXmlIndexMatcher->setType('sitemaps.org.xml.index');                        
            $this->sitemapIdentifier->addMatcher($sitemapsOrgXmlIndexMatcher);            
        }
        
        return $this->sitemapIdentifier;
    }
    
    
}