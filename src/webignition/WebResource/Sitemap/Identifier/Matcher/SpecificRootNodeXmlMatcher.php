<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

/**
 *  
 */
abstract class SpecificRootNodeXmlMatcher extends XmlMatcher {         
  
    /**
     * 
     * @param string content
     * @return boolean
     */
    public function matches($content = null) {        
        if (!parent::matches($content)) {
            return false;
        }
        
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($content);

        return $domDocument->documentElement->nodeName == $this->getRootNodeName();
    }
    
    /**
     * @return string
     */
    abstract protected function getRootNodeName();
}