<?php

declare(strict_types = 1);

// provider that organizes controllers as services
use Monolog\Logger;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

// Silex security provider
//$app->register(new Silex\Provider\SecurityServiceProvider());

// register logging provider
$app->register(new Silex\Provider\MonologServiceProvider(), [
    'monolog.logfile' => '/var/log/modus_create/error.log',
    'monolog.level' => Logger::ERROR,
]);

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => PATH_PROJECT . 'src/Modus/View',
]);
