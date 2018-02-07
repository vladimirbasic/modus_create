<?php

declare(strict_types=1);

namespace Modus\Test\Integration\Controller\Vehicles;

use Symfony\Component\HttpFoundation\Response;
use Modus\Test\Integration\IntegrationTestCase;

class PostInvalidTest extends IntegrationTestCase
{
    /**
     * @param array $params
     * @param array $expected
     * @param string $withRatings
     * @dataProvider getData
     */
    public function testFiltering(array $params, array $expected, string $withRatings, int $statusCode)
    {
        // act
        $url = '/vehicles' . $withRatings;
        $this->client->post($url, $params);
        $response = $this->client->getResponse();

        // assert
        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($expected, json_decode($response->getContent(), true));
        $this->checkDefaultResponseHeaders($response->headers);
    }

    public function getData()
    {
        return [
            [// #0 no results expected
                'params' => [
                    'modelYear' => 2013,
                    'manufacturer' => 'Ford',
                ],
                'expected' => [
                    'Count' => 0,
                    'Results' => []
                ],
                'withRatings' => '',
                'statusCode' => Response::HTTP_BAD_REQUEST,
            ],
            [// #1 invalid input data
                'params' => [
                    'modelYear' => 1000,
                    'manufacturer' => 'A',
                    'model' => 'A',
                ],
                'expected' => [
                    'Count' => 0,
                    'Results' => []
                ],
                'withRatings' => '',
                'statusCode' => Response::HTTP_BAD_REQUEST,
            ],
        ];
    }
}
