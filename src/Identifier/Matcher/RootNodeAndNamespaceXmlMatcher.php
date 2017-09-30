<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class RootNodeAndNamespaceXmlMatcher extends RootNodeXmlMatcher
{
    /**
     * @var string
     */
    private $rootNamespacePattern;

    /**
     * @param string $rootNamespacePattern
     * @param string $rootNodeName
     */
    public function __construct($rootNamespacePattern, $rootNodeName)
    {
        parent::__construct($rootNodeName);
        $this->rootNamespacePattern = $rootNamespacePattern;
    }

    /**
     * {@inheritdoc}
     */
    public function matches($content = null)
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
