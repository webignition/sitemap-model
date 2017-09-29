<?php

namespace webignition\WebResource\Sitemap\Identifier;

use webignition\WebResource\Sitemap\Identifier\Matcher\Matcher;

/**
 * Identify the type of sitemap by the content of the sitemap
 */
class Identifier {
    
    /**
     *
     * @var Collection of Matcher
     */
    private $matchers = array();
    
    /**
     * 
     * @return string
     */
    public function getType($content) {
        foreach ($this->matchers as $matcher) {
            if ($matcher->matches($content)) {
                return $matcher->getType();
            }
        }

        return null;
    }
    
    
    /**
     * 
     * @param Matcher $matcher
     */
    public function addMatcher(Matcher $matcher) {
        if (!array_key_exists($matcher->getType(), $this->matchers)) {
            $this->matchers[$matcher->getType()] = $matcher;
        }
    }    
    
}