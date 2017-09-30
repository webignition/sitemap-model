<?php

namespace webignition\Tests\WebResource\Sitemap\Factory;

use Guzzle\Http\Message\Response;

class HttpResponseFactory
{
    public static function create($content, $contentType)
    {
        $message = "HTTP/1.1 200 OK\nContent-Type:" . $contentType . "\n\n";

        if (!empty($content)) {
            $message .= $content;
        }

        return Response::fromMessage($message);
    }
}
