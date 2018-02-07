<?php

declare(strict_types=1);

namespace Modus\Controller;

use League\Fractal\Manager;
use League\Fractal\Resource\Item as FractalItem;
use Modus\Model\Vehicle as VehicleModel;
use Modus\Model\VehicleCollection;
use Modus\Transformer\Vehicle as VehicleTransformer;
use Symfony\Component\HttpFoundation\Request;

class VehicleController
{
    /**
     * @var VehicleTransformer
     */
    private $transformer;

    /**
     * @var VehicleModel
     */
    private $model;

    /**
     * @var Manager
     */
    private $manager;

    public function __construct(
        VehicleModel $model,
        Manager $manager,
        VehicleTransformer $transformer
    ) {
        $this->model = $model;
        $this->manager = $manager;
        $this->transformer = $transformer;
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function get(Request $request, int $year, string $manufacturer, string $model): string
    {
        $withRating = (bool)$request->get('withRating', false);

        $vehicles = $this->gatherData($year, $manufacturer, $model, $withRating);
        return $this->prepareResponse($vehicles);
    }

    /**
     * @throws \UnexpectedValueException
     * @throws \LogicException
     */
    public function post(Request $request): string
    {
        $withRating = (bool)$request->get('withRating', false);
        $input = json_decode($request->getContent(), true);

        $year = (int)$input['modelYear'];
        $manufacturer = (string)$input['manufacturer'];
        $model = (string)$input['model'];

        $vehicles = $this->gatherData($year, $manufacturer, $model, $withRating);
        return $this->prepareResponse($vehicles);
    }

    private function gatherData(int $year, string $manufacturer, string $model, bool $withRating): VehicleCollection
    {
        $vehicles = $this->model->getVehicles($year, $manufacturer, $model);

        if ($withRating) {
            $this->model->appendRating($vehicles);
        }

        return $vehicles;
    }

    private function prepareResponse(VehicleCollection $vehicles): string
    {
        $resource = new FractalItem($vehicles, $this->transformer, 'vehicle');
        $output = $this->manager->createData($resource);

        return $output->toJson();
    }
}
