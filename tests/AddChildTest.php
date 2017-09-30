<?php

namespace webignition\Tests\WebResource\Sitemap;

use webignition\Tests\WebResource\Sitemap\Factory\FixtureLoader;
use webignition\Tests\WebResource\Sitemap\Factory\SitemapHelper;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Sitemap;

class AddChildTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Factory
     */
    private $factory;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->factory = new Factory();
    }

    public function testAddChildToNonIndexSitemap()
    {
        $sitemap = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_CONTENT);

        $this->assertFalse($sitemap->addChild(new Sitemap()));
    }

    public function testAddChildToIndexSitemap()
    {
        $sitemap = SitemapHelper::createXmlIndexSitemap();

        $this->assertTrue($sitemap->addChild(new Sitemap()));
    }

    public function testAddingChildIsIdempotent()
    {
        $sitemap = SitemapHelper::createXmlIndexSitemap();
        $childSitemap = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_INDEX_CONTENT);

        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertCount(1, $sitemap->getChildren());

        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertCount(1, $sitemap->getChildren());
    }

    public function testAddingMultipleChildren()
    {
        $sitemap = SitemapHelper::createXmlIndexSitemap();

        $childSitemap1 = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_EXAMPLE_1);
        $childSitemap2 = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_EXAMPLE_2);
        $childSitemap3 = SitemapHelper::createXmlSitemap(FixtureLoader::SITEMAP_XML_EXAMPLE_3);

        $childSitemap1->setUrl('http://example.com/sitemap1.xml');
        $childSitemap2->setUrl('http://example.com/sitemap2.xml');
        $childSitemap3->setUrl('http://example.com/sitemap3.xml');

        $this->assertTrue($sitemap->addChild($childSitemap1));
        $this->assertTrue($sitemap->addChild($childSitemap2));
        $this->assertTrue($sitemap->addChild($childSitemap3));

        $this->assertCount(3, $sitemap->getChildren());
    }
}
