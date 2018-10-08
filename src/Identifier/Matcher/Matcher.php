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

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
