<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class RootNodeAndNamespaceXmlMatcher extends RootNodeXmlMatcher
{
    /**
     * @var string
     */
    private $rootNamespacePattern;

    public function __construct(string $rootNamespacePattern, string $rootNodeName, string $type)
    {
        parent::__construct($rootNodeName, $type);
        $this->rootNamespacePattern = $rootNamespacePattern;
    }

    public function matches(?string $content = null): bool
    {
        if (!parent::matches($content)) {
            return false;
        }

        $matchCount = preg_match(
            $this->rootNamespacePattern,
            $this->getDomDocument()->documentElement->getAttribute('xmlns')
        );

        return $matchCount > 0;
    }
}
