<?php

namespace webignition\WebResource\Sitemap\Identifier;

use webignition\WebResource\Sitemap\Identifier\Matcher\Matcher;
use webignition\WebResource\Sitemap\Identifier\Matcher\MatcherInterface;

/**
 * Identify the type of sitemap by the content of the sitemap
 */
class Identifier
{
    /**
     * @var MatcherInterface[]
     */
    private $matchers = [];

    /**
     * @return string
     */
    public function getType($content)
    {
        foreach ($this->matchers as $matcher) {
            if ($matcher->matches($content)) {
                return $matcher->getType();
            }
        }

        return null;
    }

    /**
     * @param MatcherInterface $matcher
     */
    public function addMatcher(MatcherInterface $matcher)
    {
        if (!array_key_exists($matcher->getType(), $this->matchers)) {
            $this->matchers[$matcher->getType()] = $matcher;
        }
    }
}
