<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

interface MatcherInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $content
     *
     * @return bool
     */
    public function matches($content = null);
}
