<?php

namespace ModusTest\Unit\Model\VehicleValueObject;

use Modus\Model\VehicleCollection;
use Modus\Test\Unit\UnitTestCase;

class AppendInvalidTest extends UnitTestCase
{
    public function testMethod()
    {
        // arrange
        $vehicleCollection = new VehicleCollection()
        ;$this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('VehicleCollection can only contain instances of VehicleValueObject');

        // act
        $vehicleCollection->append([
            'crashRating' => 'some rating',
            'description' => 'some description',
            'vehicleId' => 'some id',
        ]);

    }
}