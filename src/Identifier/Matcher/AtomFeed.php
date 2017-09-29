<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class AtomFeed extends SpecificRootNodeAndNamespaceXmlMatcher
{
    const ROOT_NODE_NAME = 'feed';
    const ROOT_NAMESPACE_PATTERN = '/http:\/\/www\.w3.org\/2005\/Atom/';

    /**
     * {@inheritdoc}
     */
    public function matches($content = null)
    {
        return parent::matches($content);
    }

    /**
     * {@inheritdoc}
     */
    protected function getRootNodeName()
    {
        return self::ROOT_NODE_NAME;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRootNamespacePattern()
    {
        return self::ROOT_NAMESPACE_PATTERN;
    }
}
