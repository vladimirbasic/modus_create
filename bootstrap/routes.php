<?php

declare(strict_types=1);

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Modus\Controller\DocumentationController;
use Modus\Controller\VehicleController;
use Modus\SchemaValidator\Vehicle as VehicleSchemaValidator;

# DocumentationController
$app->get('/documentation', DocumentationController::class . ':get');

# VehiclesController
$app->get('/vehicles/{year}/{manufacturer}/{model}', VehicleController::class . ':get')
    ->assert('year', '\d+');
$app->post('/vehicles', VehicleController::class . ':post')
    ->before(function (Request $request, Application $app) {
        $app[VehicleSchemaValidator::class]($request->getContent());
    });