<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

use webignition\NormalisedUrl\NormalisedUrl;

class TextListMatcher extends Matcher
{
    /**
     * {@inheritdoc}
     */
    public function matches($content = null)
    {
        $content = trim($content);

        if (empty($content)) {
            return false;
        }

        if ($content != strip_tags($content)) {
            return false;
        }

        $contentLines = explode("\n", $content);

        foreach ($contentLines as $contentLine) {
            $url = new NormalisedUrl($contentLine);
            if (!$url->hasScheme()) {
                return false;
            }
        }

        return true;
    }
}
