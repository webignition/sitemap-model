<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use GuzzleHttp\Message\MessageFactory;

class HttpResponseFactory
{
    const CONTENT_TYPE_ATOM = 'application/atom+xml';
    const CONTENT_TYPE_RSS = 'application/rss+xml';
    const CONTENT_TYPE_XML = 'text/xml';
    const CONTENT_TYPE_TXT = 'text/plain';
    const CONTENT_TYPE_HTML = 'text/html';

    public static function create($content, $contentType)
    {
        $messageFactory = new MessageFactory();

        return $messageFactory->createResponse(
            200,
            [
                'content-type' => $contentType,
            ],
            $content
        );
    }
}
