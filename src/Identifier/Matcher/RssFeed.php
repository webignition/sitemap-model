<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

/**
 *  
 */
class RssFeed extends SpecificRootNodeXmlMatcher {         
  
    /**
     * 
     * @param string content
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
        return 'rss';
    }
}