<?php

declare(strict_types=1);

namespace Modus\Test\Integration\Controller\Vehicles;

use Symfony\Component\HttpFoundation\Response;
use Modus\Test\Integration\IntegrationTestCase;

class GetTest extends IntegrationTestCase
{
    /**
     * @param string $url
     * @param array $expected
     * @dataProvider getData
     */
    public function testFiltering(string $url, array $expected)
    {
        // act
        $this->client->get('/vehicles' . $url);
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
                'url' => '/2013/Ford/Crown%20Victoria',
                'expected' => [
                    'Count' => 0,
                    'Results' => []
                ],
            ],
            [// #1 results expected without crash rating
                'url' => '/2015/Audi/A3',
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
            ],
            [// #2 results expected with crash rating
                'url' => '/2015/Audi/A3?withRating=true',
                'expected' => [
                    'Count' => 4,
                    'Results' => [
                        [
                            'CrashRating' => '5',
                            'Description' => '2015 Audi A3 4 DR AWD',
                            'VehicleId' => 9403
                        ],
                        [
                            'CrashRating' => '5',
                            'Description' => '2015 Audi A3 4 DR FWD',
                            'VehicleId' => 9408
                        ],
                        [
                            'CrashRating' => 'Not Rated',
                            'Description' => '2015 Audi A3 C AWD',
                            'VehicleId' => 9405
                        ],
                        [
                            'CrashRating' => 'Not Rated',
                            'Description' => '2015 Audi A3 C FWD',
                            'VehicleId' => 9406
                        ]
                    ]
                ],
            ],
        ];
    }
}
