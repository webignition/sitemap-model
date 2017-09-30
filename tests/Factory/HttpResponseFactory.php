<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use Guzzle\Http\Message\Response;

class HttpResponseFactory
{
    const CONTENT_TYPE_ATOM = 'application/atom+xml';
    const CONTENT_TYPE_RSS = 'application/rss+xml';
    const CONTENT_TYPE_XML = 'text/xml';
    const CONTENT_TYPE_TXT = 'text/plain';
    const CONTENT_TYPE_HTML = 'text/html';

    public static function create($content, $contentType)
    {
        $message = "HTTP/1.1 200 OK\nContent-Type:" . $contentType . "\n\n";

        if (!empty($content)) {
            $message .= $content;
        }

        return Response::fromMessage($message);
    }
}
