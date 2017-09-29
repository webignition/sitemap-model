<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

abstract class SpecificRootNodeAndNamespaceXmlMatcher extends SpecificRootNodeXmlMatcher
{
    /**
     * {@inheritdoc}
     */
    public function matches($content = null)
    {
        if (!parent::matches($content)) {
            return false;
        }

        $matchCount = preg_match(
            $this->getRootNamespacePattern(),
            $this->getDomDocument()->documentElement->getAttribute('xmlns')
        );

        return $matchCount > 0;
    }

    /**
     * @return string
     */
    abstract protected function getRootNamespacePattern();
}
