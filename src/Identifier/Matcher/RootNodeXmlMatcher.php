<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class RootNodeXmlMatcher extends XmlMatcher
{
    /**
     * @var string
     */
    private $rootNodeName;

    /**
     * @param string $rootNodeName
     * @param string $type
     */
    public function __construct($rootNodeName, $type)
    {
        parent::__construct($type);
        $this->rootNodeName = $rootNodeName;
    }

    /**
     * {@inheritdoc}
     */
    public function matches($content = null)
    {
        if (!parent::matches($content)) {
            return false;
        }

        $domDocument = new \DOMDocument();
        $domDocument->loadXML($content);

        return $domDocument->documentElement->nodeName == $this->rootNodeName;
    }
}
