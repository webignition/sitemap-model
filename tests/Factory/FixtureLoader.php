<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

class FixtureLoader
{
    const ATOM_CONTENT = 'atom.xml';
    const RSS_CONTENT = 'rss.xml';
    const SITEMAP_XML_CONTENT = 'sitemap.xml';
    const SITEMAP_TXT_CONTENT = 'sitemap.txt';
    const SITEMAP_XML_INDEX_CONTENT = 'sitemap.index.xml';
    const SITEMAP_XML_WITH_IMAGES_CONTENT = 'sitemap.with-images.xml';

    const SITEMAP_XML_EXAMPLE_1 = 'example.com.sitemap.01.xml';
    const SITEMAP_XML_EXAMPLE_2 = 'example.com.sitemap.02.xml';
    const SITEMAP_XML_EXAMPLE_3 = 'example.com.sitemap.03.xml';

    const SITEMAP_XML_INVALID_CONTENT = 'sitemap.invalid.xml';

    const HTML_CONTENT = 'html5.html';
    const TEXT_CONTENT = 'plain.txt';

    public static function load($name)
    {
        $fixturePath = realpath(__DIR__ . '/../fixtures/Common/' . $name);

        if (empty($fixturePath)) {
            throw new \RuntimeException(sprintf(
                'Unknown fixture %s',
                $name
            ));
        }

        return file_get_contents($fixturePath);
    }
}
