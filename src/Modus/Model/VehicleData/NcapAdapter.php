<?php

namespace Modus\Model\VehicleData;

use InvalidArgumentException;
use Modus\Exception\CurlAdapterException;
use Modus\Library\CurlAdapter;
use Modus\Model\VehicleCollection;
use Modus\Model\VehicleDataInterface;
use Modus\Model\VehicleValueObject;
use UnexpectedValueException;

class NcapAdapter implements VehicleDataInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var CurlAdapter
     */
    private $curlAdapter;

    public function __construct(CurlAdapter $curlAdapter)
    {
        $this->curlAdapter = $curlAdapter;
        $this->url = 'https://one.nhtsa.gov/webapi/api/SafetyRatings/';
    }

    /**
     * @throws \InvalidArgumentException
     * @throws \UnexpectedValueException
     */
    public function getVehicles(int $year, string $manufacturer, string $model): VehicleCollection
    {
        $urlSegment = 'modelyear/' . $year
            . '/make/' . rawurlencode($manufacturer)
            . '/model/' . rawurlencode($model);

        $data = $this->sendRequest($urlSegment);

        $vehicleCollection = new VehicleCollection();
        try {
            foreach ($data['Results'] as $vehicle) {
                $vehicleCollection->append(new VehicleValueObject($vehicle));
            }
        } catch (InvalidArgumentException $e) {
            throw new UnexpectedValueException('Invalid vehicle data');
        }

        return $vehicleCollection;
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function getRatingData(int $vehicleId): array
    {
        return $this->sendRequest('VehicleId/' . $vehicleId);
    }

    /**
     * @throws UnexpectedValueException
     */
    protected function sendRequest(string $urlSegment): array
    {
        $headers = [
            'Content-Type: ' . CONTENT_TYPE_JSON,
            'Accept: application/json',
        ];
        $url = $this->url . $urlSegment . '?format=json';

        try {
            return $this->curlAdapter->sendRequest($url, $headers);
        } catch (CurlAdapterException $e) {
            throw new UnexpectedValueException('Invalid data response');
        }
    }
}
