<?php

namespace webignition\WebResource\Sitemap;

use webignition\WebResourceInterfaces\SitemapInterface;

class Types
{
    public static $types = [
        SitemapInterface::TYPE_ATOM,
        SitemapInterface::TYPE_RSS,
        SitemapInterface::TYPE_SITEMAPS_ORG_XML,
        SitemapInterface::TYPE_SITEMAPS_ORG_TXT,
        SitemapInterface::TYPE_SITEMAPS_ORG_XML_INDEX,
    ];
}
