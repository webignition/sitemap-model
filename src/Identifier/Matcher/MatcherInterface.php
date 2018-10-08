<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

interface MatcherInterface
{
    public function getType(): string;

    public function matches(?string $content = null): bool;
}
