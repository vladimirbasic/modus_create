<?php

namespace Modus\Model;

interface VehicleDataInterface
{
    public function getVehicles(int $year, string $manufacturer, string $model): VehicleCollection;

    public function getRatingData(int $vehicleId): array;
}
