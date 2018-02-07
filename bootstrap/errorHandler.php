<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Modus\Exception\InvalidJsonSchemaException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app->error(function (Throwable $e) use ($app) {
    $app['monolog']->error($e->getMessage());

    if ($e instanceof InvalidJsonSchemaException) {
        return new Response(json_encode(['Count' => 0, 'Results' => []]), Response::HTTP_BAD_REQUEST);
    } elseif ($e instanceof InvalidArgumentException) {
        return new Response(json_encode(['Count' => 0, 'Results' => []]), Response::HTTP_OK);
    } elseif ($e instanceof MethodNotAllowedHttpException) {
        $code = Response::HTTP_METHOD_NOT_ALLOWED;
    } elseif ($e instanceof NotFoundHttpException) {
        $code = Response::HTTP_NOT_FOUND;
    } elseif ($e instanceof UnexpectedValueException) {
        $message = 'Bad gateway';
        $code = Response::HTTP_BAD_GATEWAY;
    } else {
        $message = 'Internal server error';
        $code = Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    $message = json_encode(
        ['error' => ['message' => $message ?? $e->getMessage()]],
        JSON_UNESCAPED_UNICODE
    );

    $headers = [];
    if (ENVIRONMENT !== ENVIRONMENT_PRODUCTION) {
        $headers = ['Error' => $e->getMessage()];
    }

    return new Response($message, $code, $headers);
});
