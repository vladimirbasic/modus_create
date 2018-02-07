<?php

declare(strict_types=1);

namespace Modus\Model;

use UnexpectedValueException;

class Vehicle
{
    /**
     * @var VehicleDataInterface
     */
    private $vehicleData;

    public function __construct(VehicleDataInterface $vehicleData)
    {
        $this->vehicleData = $vehicleData;
    }

    public function getVehicles(int $year, string $manufacturer, string $model): VehicleCollection
    {
        return $this->vehicleData->getVehicles($year, $manufacturer, $model);
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function appendRating(VehicleCollection $vehicles): void
    {
        /** @var VehicleValueObject $vehicle */
        foreach ($vehicles as $index => $vehicle) {
            $ratingData = $this->vehicleData->getRatingData($vehicle->getVehicleId());
            if (!isset($ratingData['Results'][0]['OverallRating'])) {
                    throw new UnexpectedValueException('Could not retrieve crush ratings.');
            }
            $vehicles[$index]->setCrashRating($ratingData['Results'][0]['OverallRating']);
        }
    }
}
