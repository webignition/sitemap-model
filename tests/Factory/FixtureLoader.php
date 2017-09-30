<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

class FixtureLoader
{
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
