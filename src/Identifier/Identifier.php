<?php

namespace webignition\WebResource\Sitemap\Identifier;

use webignition\WebResource\Sitemap\Identifier\Matcher\MatcherInterface;
use webignition\WebResource\Sitemap\Identifier\Matcher;

/**
 * Identify the type of sitemap by the content of the sitemap
 */
class Identifier
{
    /**
     * @var MatcherInterface[]
     */
    private $matchers = [];

    public function __construct()
    {
        $foo = [
            'sitemaps.org.xml' => Matcher\SitemapsOrgXml::class,
            'sitemaps.org.txt' => Matcher\SitemapsOrgTxt::class,
            'application/rss+xml' => Matcher\RssFeed::class,
            'application/atom+xml' => Matcher\AtomFeed::class,
            'sitemaps.org.xml.index' => Matcher\SitemapsOrgXmlIndex::class,
        ];

        foreach ($foo as $type => $class) {
            /* @var MatcherInterface $matcher */
            $matcher = new $class;
            $matcher->setType($type);
            $this->matchers[$type] = $matcher;
        }
    }

    /**
     * @param string $content
     *
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
}
