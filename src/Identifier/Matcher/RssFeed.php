<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class RssFeed extends SpecificRootNodeXmlMatcher
{
    const ROOT_NODE_NAME = 'rss';

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
}
