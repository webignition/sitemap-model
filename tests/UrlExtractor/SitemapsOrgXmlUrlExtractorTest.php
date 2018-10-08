<?php

namespace webignition\WebResource\Sitemap\Tests\UrlExtractor;

use webignition\WebResource\Sitemap\Factory;
use webignition\WebResource\Sitemap\UrlExtractor\SitemapsOrgXmlUrlExtractor;
use webignition\WebResource\TestingTools\FixtureLoader;

class SitemapsOrgXmlUrlExtractorTest extends \PHPUnit\Framework\TestCase
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
    public function testExtractInvalidContent(string $fixtureName)
    {
        $fixture = FixtureLoader::load($fixtureName);

        $extractor = new SitemapsOrgXmlUrlExtractor();
        $urls = $extractor->extract($fixture);

        $this->assertEmpty($urls);
    }

    public function extractInvalidContentDataProvider(): array
    {
        FixtureLoader::$fixturePath = __DIR__  . '/../Fixtures';

        return [
            'xml no namespace' => [
                'fixtureName' => 'sitemap.no-namespace.xml',
            ],
        ];
    }
}
