<?php

namespace webignition\WebResource\Sitemap\Tests;

use webignition\WebResource\Exception\InvalidContentTypeException;
use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\Tests\Services\SitemapFactory;
use webignition\WebResource\TestingTools\FixtureLoader;

class AddChildTest extends \PHPUnit\Framework\TestCase
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

        FixtureLoader::$fixturePath = __DIR__  . '/Fixtures';
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testAddChildToNonIndexSitemap()
    {
        $sitemap = SitemapFactory::createXmlSitemap(FixtureLoader::load('sitemap.xml'));
        $childSitemap = SitemapFactory::createXmlSitemap(FixtureLoader::load('sitemap.xml'));

        $this->assertFalse($sitemap->addChild($childSitemap));
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testAddChildToIndexSitemap()
    {
        $sitemap = SitemapFactory::createXmlIndexSitemap();
        $childSitemap = SitemapFactory::createXmlSitemap(FixtureLoader::load('sitemap.xml'));

        $this->assertTrue($sitemap->addChild($childSitemap));
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testAddingChildIsIdempotent()
    {
        $sitemap = SitemapFactory::createXmlIndexSitemap();
        $childSitemap = SitemapFactory::createXmlSitemap(FixtureLoader::load('sitemap.index.xml'));

        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertCount(1, $sitemap->getChildren());

        $this->assertTrue($sitemap->addChild($childSitemap));
        $this->assertCount(1, $sitemap->getChildren());
    }

    /**
     * @throws InvalidContentTypeException
     */
    public function testAddingMultipleChildren()
    {
        $sitemap = SitemapFactory::createXmlIndexSitemap();

        $childSitemap1 = SitemapFactory::createXmlSitemap(FixtureLoader::load('example.com.sitemap.01.xml'));
        $childSitemap2 = SitemapFactory::createXmlSitemap(FixtureLoader::load('example.com.sitemap.02.xml'));
        $childSitemap3 = SitemapFactory::createXmlSitemap(FixtureLoader::load('example.com.sitemap.03.xml'));

        $this->assertTrue($sitemap->addChild($childSitemap1));
        $this->assertTrue($sitemap->addChild($childSitemap2));
        $this->assertTrue($sitemap->addChild($childSitemap3));

        $this->assertCount(3, $sitemap->getChildren());
    }
}
