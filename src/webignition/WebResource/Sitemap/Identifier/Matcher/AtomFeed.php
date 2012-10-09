<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;



/**
 *  
 */
class AtomFeed extends SpecificRootNodeAndNamespaceXmlMatcher {   
   
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
        return 'feed';
    }
    
    
    /**
     * 
     * @return string
     */
    protected function getRootNamespacePattern() {
        return '/http:\/\/www\.w3.org\/2005\/Atom/';
    }
}