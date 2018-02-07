<?php

namespace ModusTest\Unit\Model\VehicleValueObject;

use Modus\Model\VehicleValueObject;
use Modus\Test\Unit\UnitTestCase;

class ConstructInvalidTest extends UnitTestCase
{
    /**
     * @dataProvider getData
     */
    public function testMethod(array $input, string $message)
    {
        // arrange
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($message);

        // act
        new VehicleValueObject($input);

    }

    public function getData()
    {
        return [
            [ // #0 VehicleDescription field in the result is missing
                'input' => ['VehicleId' => 'some id'],
                'message' => 'VehicleDescription element missing'
            ],
            [ // #1 VehicleId field in the result is missing
                'input' => ['VehicleDescription' => 'some description'],
                'message' => 'VehicleId element missing'
            ],
        ];
    }
}