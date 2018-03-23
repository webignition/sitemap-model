<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

abstract class Matcher implements MatcherInterface
{
    /**
     * Unique string identifying the type of sitemap this tries to match
     *
     * @var string
     */
    private $type = null;

    /**
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }
}
