<?php

namespace webignition\WebResource\Sitemap\Identifier\Matcher;

class RootNodeXmlMatcher extends XmlMatcher
{
    /**
     * @var string
     */
    private $rootNodeName;

    public function __construct(string $rootNodeName, string $type)
    {
        parent::__construct($type);
        $this->rootNodeName = $rootNodeName;
    }

    public function matches(?string $content = null): bool
    {
        if (!parent::matches($content)) {
            return false;
        }

        $domDocument = new \DOMDocument();
        $domDocument->loadXML($content);

        return $domDocument->documentElement->nodeName == $this->rootNodeName;
    }
}
