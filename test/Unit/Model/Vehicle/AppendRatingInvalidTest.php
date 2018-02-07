<?php

namespace ModusTest\Unit\Model\VehicleValueObject;

use Modus\Model\Vehicle;
use Modus\Model\VehicleCollection;
use Modus\Model\VehicleDataInterface;
use Modus\Model\VehicleValueObject;
use Modus\Test\Unit\UnitTestCase;

class AppendRatingInvalidTest extends UnitTestCase
{
    /**
     * @dataProvider getData
     */
    public function testMethod(array $data)
    {
        // arrange
        $vehicleId = 1;
        $prophetDataObject = $this->prophesize(VehicleDataInterface::class);
        $prophetDataObject->getRatingData($vehicleId)
            ->shouldBeCalled()
            ->willReturn($data);
        /* @var $dataObject VehicleDataInterface */
        $dataObject = $prophetDataObject->reveal();

        $model = new Vehicle($dataObject);

        $vehicleCollection = new VehicleCollection();
        $vehicleCollection->append(new VehicleValueObject([
            'VehicleDescription' => 'some Vehicle Description',
            'VehicleId' => $vehicleId,
        ]));

        $this->expectException(\UnexpectedValueException::class);
        $this->expectExceptionMessage('Could not retrieve crush ratings.');

        // act
        $model->appendRating($vehicleCollection);

    }

    public function getData()
    {
        return [
            [ // #0 Results missing from 3rd party response
                'input' => [],
            ],
            [ // #1 Results empty in 3rd party response
                'input' => ['Results' => []],
            ],
            [ // #2 OverallRating missing in Results
                'input' => ['Results' => [[]]],
            ],
        ];
    }
}