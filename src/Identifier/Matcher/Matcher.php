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
     * {@inheritdoc}
     */
    public function setType($type)
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

    /**
     * {@inheritdoc}
     */
    abstract public function matches($content = null);
}
