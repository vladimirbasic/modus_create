<?php

declare(strict_types=1);

namespace Modus\Test\Integration\Controller\Vehicles;

use Modus\Exception\CurlAdapterException;
use Modus\Library\CurlAdapter;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Response;
use Modus\Test\Integration\IntegrationTestCase;

class GetInvalidTest extends IntegrationTestCase
{
    public function tearDown()
    {
        $this->app[CurlAdapter::class] = new CurlAdapter();
        parent::tearDown();
    }

    /**
     * @param string $url
     * @param array $expected
     * @dataProvider getData
     */
    public function testFiltering(string $url, int $statusCode, array $expected)
    {
        // arrange
        $curlAdapterProphet = $this->prophesize(CurlAdapter::class);
        $curlAdapterProphet
            ->sendRequest(Argument::type('string'), Argument::type('array'))
            ->willThrow(CurlAdapterException::class);
        $this->app[CurlAdapter::class] = $curlAdapterProphet->reveal();

        // act
        $this->client->get('/vehicles' . $url);
        $response = $this->client->getResponse();

        // assert
        $this->assertEquals($statusCode, $response->getStatusCode());
        $this->assertEquals($expected, json_decode($response->getContent(), true));
        $this->checkDefaultResponseHeaders($response->headers);
    }

    public function getData()
    {
        return [
            [// #0 results expected without crash rating
                'url' => '/2015/Audi/A3',
                'statusCode' => Response::HTTP_BAD_GATEWAY,
                'expected' => [
                    'error' => ['message' => 'Bad gateway']
                ],
            ],
        ];
    }
}
