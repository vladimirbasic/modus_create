<?php

declare(strict_types = 1);

ini_set('display_errors', '0');

require_once realpath(__DIR__ . '/../bootstrap') . '/constants.php';
require_once PATH_PROJECT . 'vendor/autoload.php';

$app = new Silex\Application();

try {
    require_once PATH_BOOTSTRAP . 'bootstrap.php';

    $app->run();
} catch (Throwable $e) {
    http_response_code(500);
    header('Access-Control-Allow-Origin: ' . ACCESS_CONTROL_ALLOW_ORIGIN);
    header('Content-Type: ' . CONTENT_TYPE_JSON);
    header('Access-Control-Allow-Headers: ' . ACCESS_CONTROL_ALLOW_HEADERS);
    header('Access-Control-Allow-Methods: ' . ACCESS_CONTROL_ALLOW_METHODS);

    $app['monolog']->error($e->getMessage());

    echo json_encode(['error' => ['message' => 'Internal server error']]);
}