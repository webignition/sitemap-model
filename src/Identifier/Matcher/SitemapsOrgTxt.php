<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

use webignition\NormalisedUrl\NormalisedUrl;

/**
 *  
 */
class SitemapsOrgTxt extends Matcher {   
    
    
    public function matches($content = null) {        
        if (trim($content) == '') {
            return false;
        }
        
        if ($content != strip_tags($content)) {
            return false;
        }
        
        $contentLines = explode("\n", $content);
        
        foreach ($contentLines as $contentLine) {
            $url = new NormalisedUrl($contentLine);
            if (!$url->hasScheme()) {
                return false;
            }            
        }
        
        return true;
    }
}