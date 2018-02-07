<?php

declare(strict_types = 1);

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app->after(function (Request $request, Response $response) use ($app) {
    if (!$response->headers->get('Content-Type')) {
        $response->headers->set('Content-Type', CONTENT_TYPE_JSON);
    }
    $response->headers->set('Access-Control-Allow-Origin', ACCESS_CONTROL_ALLOW_ORIGIN);
    $response->headers->set('Access-Control-Allow-Headers', ACCESS_CONTROL_ALLOW_HEADERS);
    $response->headers->set('Access-Control-Allow-Methods', ACCESS_CONTROL_ALLOW_METHODS);
});
