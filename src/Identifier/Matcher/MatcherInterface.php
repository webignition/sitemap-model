<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

interface MatcherInterface
{
    /**
     * @param string $type
     */
    public function setType($type);

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
