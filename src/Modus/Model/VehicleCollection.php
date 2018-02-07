<?php

namespace Modus\Model;

use InvalidArgumentException;

class VehicleCollection extends \ArrayObject
{
    /**
     * @param VehicleValueObject $value
     *
     * @throws \InvalidArgumentException
     */
    public function append($value): void
    {
        if (!($value instanceof VehicleValueObject)) {
            throw new InvalidArgumentException('VehicleCollection can only contain instances of VehicleValueObject');
        }

        parent::append($value);
    }
}
