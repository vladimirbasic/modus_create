<?php

namespace Modus\Model;

use InvalidArgumentException;

class VehicleValueObject
{
    /**
     * @var string|null
     */
    private $crashRating;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $vehicleId;

    /**
     * @throws \InvalidArgumentException
     */
    public function __construct(array $vehicle)
    {
        if (!isset($vehicle['VehicleDescription'])) {
            throw new InvalidArgumentException('VehicleDescription element missing');
        }
        if (!isset($vehicle['VehicleId'])) {
            throw new InvalidArgumentException('VehicleId element missing');
        }

        $this->crashRating = $vehicle['CrashRating'] ?? null;
        $this->description = (string)$vehicle['VehicleDescription'];
        $this->vehicleId = (int)$vehicle['VehicleId'];
    }

    public function setCrashRating(?string $crashRating): void
    {
        $this->crashRating = $crashRating;
    }

    public function getCrashRating(): ?string
    {
        return $this->crashRating;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getVehicleId(): int
    {
        return $this->vehicleId;
    }
}
