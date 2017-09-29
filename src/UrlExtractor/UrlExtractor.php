<?php

namespace webignition\WebResource\Sitemap\UrlExtractor;

abstract class UrlExtractor {

    abstract public function extract($content);
    
}