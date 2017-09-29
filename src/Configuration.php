<?php

namespace webignition\WebResource\Sitemap;

class Configuration
{
    /**
     * Maps sitemap type to name of URL extractor class that
     * is to be used to extact URLs from said type
     *
     * @var array
     */
    private $typeToUrlExtractorClassMap = array();

    /**
     * @param array $map
     */
    public function setTypeToUrlExtractorClassMap($map)
    {
        $this->typeToUrlExtractorClassMap = $map;
    }

    /**
     * @return array
     */
    public function getTypeToUrlExtractorClassMap()
    {
        return $this->typeToUrlExtractorClassMap;
    }

    /**
     * @param string $type
     *
     * @return string
     */
    public function getExtractorClassForType($type)
    {
        return isset($this->typeToUrlExtractorClassMap[$type]) ? $this->typeToUrlExtractorClassMap[$type] : null;
    }
}
