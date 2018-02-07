<?php

declare(strict_types=1);

use Silex\Application;

ini_set('display_errors', '1');

if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'test');
}

require_once realpath(__DIR__ . '/../../bootstrap') . '/constants.php';
require PATH_PROJECT . 'vendor/autoload.php';

$app = new Application();
require_once PATH_BOOTSTRAP . 'bootstrap.php';

$app->view(function (array $controllerResult) use ($app) {
    return $app->json($controllerResult);
});

return [$app];