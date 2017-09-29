<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

/**
 *  
 */
abstract class XmlMatcher extends Matcher {   
    
    /**
     *
     * @var \DOMDocument
     */
    private $domDocument = null;
    
    
    /**
     *
     * @var boolean
     */
    private $isParseableXml = null;
    
    
    /**
     * 
     * @param string $content
     * @return boolean
     */
    public function matches($content = null) {
        if (trim($content) == '') {
            return false;
        }        
        
        libxml_use_internal_errors(true);
        
        $this->domDocument = new \DOMDocument();
        $this->isParseableXml = $this->domDocument->loadXML($content);       
                
        libxml_use_internal_errors(false);
        
        return $this->isParseableXml();                     
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function isParseableXml() {
        return $this->isParseableXml;
    }
    
    /**
     * 
     * @return \DOMDocument
     */
    protected function getDomDocument() {
        return $this->domDocument;
    }
}