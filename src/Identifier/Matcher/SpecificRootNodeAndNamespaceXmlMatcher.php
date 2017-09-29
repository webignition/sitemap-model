<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

/**
 *  
 */
abstract class SpecificRootNodeAndNamespaceXmlMatcher extends SpecificRootNodeXmlMatcher {         
    

   
    /**
     * 
     * @param string content
     * @return boolean
     */
    public function matches($content = null) {        
        if (!parent::matches($content)) {
            return false;
        }  
        
        return preg_match($this->getRootNamespacePattern(), $this->getDomDocument()->documentElement->getAttribute('xmlns')) > 0;
    }
    
    
    /**
     * @return string
     */
    abstract protected function getRootNamespacePattern();
}