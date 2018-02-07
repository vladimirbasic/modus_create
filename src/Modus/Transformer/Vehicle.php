<?php

namespace Modus\Transformer;

use League\Fractal\TransformerAbstract;
use Modus\Model\VehicleCollection;

class Vehicle extends TransformerAbstract
{
    public function transform(VehicleCollection $vehicles)
    {
        $transformedData = [
            'Count' => $vehicles->count(),
            'Results' => [],
        ];

        foreach ($vehicles as $row) {
            $newEntry = [];
            if ($row->getCrashRating() !== null) {
                $newEntry['CrashRating'] = $row->getCrashRating();
            }
            $newEntry['Description'] = $row->getDescription();
            $newEntry['VehicleId'] = $row->getVehicleId();
            $transformedData['Results'][] = $newEntry;
        }

        return $transformedData;
    }
}
