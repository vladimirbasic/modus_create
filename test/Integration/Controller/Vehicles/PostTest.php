<?php

declare(strict_types=1);

namespace Modus\Test\Integration\Controller\Vehicles;

use Symfony\Component\HttpFoundation\Response;
use Modus\Test\Integration\IntegrationTestCase;

class PostTest extends IntegrationTestCase
{
    /**
     * @param array $params
     * @param array $expected
     * @param string $withRatings
     * @dataProvider getData
     */
    public function testFiltering(array $params, array $expected, string $withRatings)
    {
        // act
        $url = '/vehicles' . $withRatings;
        $this->client->post($url, $params);
        $response = $this->client->getResponse();

        // assert
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
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
                    'model' => 'Crown Victoria',
                ],
                'expected' => [
                    'Count' => 0,
                    'Results' => []
                ],
                'withRatings' => '',
            ],
            [// #1 results expected without crash rating
                'params' => [
                    'modelYear' => 2015,
                    'manufacturer' => 'Audi',
                    'model' => 'A3',
                ],
                'expected' => [
                    'Count' => 4,
                    'Results' => [
                        [
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId' => 9403
                        ],
                        [
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId' => 9408
                        ],
                        [
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId' => 9405
                        ],
                        [
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId' => 9406
                        ]
                    ]
                ],
                'withRatings' => '',
            ],
            [// #1 results expected wit crash rating
                'params' => [
                    'modelYear' => 2015,
                    'manufacturer' => 'Audi',
                    'model' => 'A3',
                ],
                'expected' => [
                    'Count' => 4,
                    'Results' => [
                        [
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId' => 9403,
                            'CrashRating' => '5'
                        ],
                        [
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId' => 9408,
                            'CrashRating' => '5'
                        ],
                        [
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId' => 9405,
                            'CrashRating' => 'Not Rated'
                        ],
                        [
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId' => 9406,
                            'CrashRating' => 'Not Rated'
                        ]
                    ]
                ],
                'withRatings' => '?withRating=true',
            ],
        ];
    }
}
