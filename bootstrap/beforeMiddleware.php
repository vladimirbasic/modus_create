<?php

declare(strict_types=1);

use Modus\Exception\InvalidJsonSchemaException;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/* @var Application $app */
$app->before(function (Request $request) {
    // GET and DELETE do not require content-type request header
    if (in_array(strtoupper($request->getMethod()), [HTTP_METHOD_GET, HTTP_METHOD_DELETE], true)) {
        return;
    }

    $contentType = $request->headers->get('Content-Type') ?? '';
    // type is always in place: "application/json; charset=utf-8"
    $contentType = explode(';', $contentType)[0];

    // compare Content-Type with allowed ones
    $allowedContentTypes = explode(',', HTTP_ACCEPT_CONTENT_TYPES);
    $allowed = false;
    foreach ($allowedContentTypes as $type) {
        if (strpos($contentType, $type) !== false) {
            $allowed = true;
            break;
        }
    }

    // Content-Type must be from list of allowed ones
    if (!$allowed) {
        throw new InvalidJsonSchemaException(['Allowed Content-Type values: ' . HTTP_ACCEPT_CONTENT_TYPES]);
    }

    // if Content-Type is 'application/json' and HTTP body has some payload
    // then that payload MUST be valid JSON
    if ($contentType === CONTENT_TYPE_JSON
        && $request->getContent() !== ''
        && json_decode($request->getContent(), true) === null
    ) {
        throw new InvalidJsonSchemaException(['Invalid JSON was sent']);
    }
}, Application::EARLY_EVENT);
