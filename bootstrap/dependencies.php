<?php

declare(strict_types=1);

use JsonSchema\Validator;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
use Modus\Controller\DocumentationController;
use Modus\Controller\VehicleController;
use Modus\Library\CurlAdapter;
use Modus\Model\Vehicle as VehicleModel;
use Modus\Model\VehicleData\NcapAdapter;
use Modus\SchemaValidator\Vehicle as VehicleSchemaValidator;
use Modus\Transformer\Vehicle as VehicleTransformer;
use Silex\Application;

(function (Application $app) {
    addControllers($app);
    addLibrary($app);
    addModels($app);
    addSchemaValidators($app);
    addTransformers($app);
    addVendor($app);
})($app);

function addControllers(Application $app): void
{
    $app[DocumentationController::class] = $app->factory(function () use ($app) {
        return new DocumentationController(
            $app['twig']
        );
    });
    $app[VehicleController::class] = $app->factory(function () use ($app) {
        return new VehicleController(
            $app[VehicleModel::class],
            $app[Manager::class],
            $app[VehicleTransformer::class]
        );
    });
}

function addLibrary(Application $app): void
{
    $app[CurlAdapter::class] = $app->factory(function () {
        return new CurlAdapter();
    });
    $app[NcapAdapter::class] = $app->factory(function () use ($app) {
        return new NcapAdapter(
            $app[CurlAdapter::class]
        );
    });
}

function addModels(Application $app): void
{
    $app[VehicleModel::class] = $app->factory(function () use ($app) {
        return new VehicleModel(
            $app[NcapAdapter::class]
        );
    });
}

function addSchemaValidators(Application $app): void
{
    $app[VehicleSchemaValidator::class] = $app->factory(function () {
        return new VehicleSchemaValidator(new Validator);
    });
}

function addTransformers(Application $app): void
{
    $app[VehicleTransformer::class] = $app->factory(function () {
        return new VehicleTransformer();
    });
}

function addVendor(Application $app): void
{
    $app[Manager::class] = $app->factory(function () {
        $manager = new Manager();
        $manager->setSerializer(new ArraySerializer());

        return $manager;
    });
}
