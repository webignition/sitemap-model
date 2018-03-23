<?php

namespace webignition\Tests\WebResource\Sitemap\UrlExtractor;

use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlUrlExtractor;
use webignition\WebResource\TestingTools\FixtureLoader;

class SitemapsOrgXmlUrlExtractorTest extends \PHPUnit_Framework_TestCase
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
        parent::setUp();
        $this->factory = new Factory();
    }

    /**
     * @dataProvider extractInvalidContentDataProvider
     *
     * @param string $fixtureName
     */
    public function testExtractInvalidContent($fixtureName)
    {
        $fixture = FixtureLoader::load($fixtureName);

        $extractor = new SitemapsOrgXmlUrlExtractor();
        $urls = $extractor->extract($fixture);

        $this->assertEmpty($urls);
    }

    /**
     * @return array
     */
    public function extractInvalidContentDataProvider()
    {
        FixtureLoader::$fixturePath = __DIR__  . '/../Fixtures';

        return [
            'xml no namespace' => [
                'fixtureName' => 'sitemap.no-namespace.xml',
            ],
        ];
    }
}
