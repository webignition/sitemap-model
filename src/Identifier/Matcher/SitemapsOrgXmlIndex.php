<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

/**
 *  
 */
class SitemapsOrgXmlIndex extends SpecificRootNodeAndNamespaceXmlMatcher {   
     
    /**
     * 
     * @param string $content
     * @return boolean
     */
    public function matches($content = null) {        
        return parent::matches($content);
    }
    
    
    /**
     * 
     * @return string
     */
    protected function getRootNodeName() {
        return 'sitemapindex';
    }
    
    
    /**
     * 
     * @return string
     */
    protected function getRootNamespacePattern() {
        return '/http:\/\/www\.(sitemaps\.org)|(google\.com)\/schemas\/sitemap\/((\d+)|(\d+\.\d+))$/';
    }
    
}