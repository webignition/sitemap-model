<?php
namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class SitemapsOrgXml extends SpecificRootNodeAndNamespaceXmlMatcher
{
    const ROOT_NODE_NAME = 'urlset';
    const ROOT_NAMESPACE_PATTERN =
        '/http:\/\/www\.(sitemaps\.org)|(google\.com)\/schemas\/sitemap\/((\d+)|(\d+\.\d+))$/';

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
