<?php

declare(strict_types=1);

namespace Modus\Test\Integration;

use Prophecy\Prophet;
use Silex\Application;
use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Modus\Library\CurlAdapter;

abstract class IntegrationTestCase extends WebTestCase
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Application
     */
    protected static $staticApp;

    /**
     * @var array
     */
    protected $requiredFixtures = [];

    /**
     * @var ClientAdapter
     */
    protected $client;

    /**
     * @var Prophet
     */
    protected $curlAdapterProphet;

    protected function setUp()
    {
        parent::setUp();

        $this->prepareClient();
    }

    public function createApplication(): Application
    {
        if (empty(self::$staticApp)) {
            [$this->app] = include realpath(__DIR__ . '/bootstrap.php');
            self::$staticApp = $this->app;
        } else {
            $this->app = self::$staticApp;
        }
        $this->curlAdapterProphet = $this->prophesize(CurlAdapter::class);
//        $this->app[CurlAdapter::class] = $this->curlAdapterProphet->reveal();
        $this->app['debug'] = true;
        unset($this->app['exception_handler']);

        return $this->app;
    }

    public function prepareClient(): void
    {
        $this->client = new ClientAdapter($this->createClient());
    }

    protected function checkDefaultResponseHeaders(ResponseHeaderBag $headers): void
    {
        $this->assertEquals(ACCESS_CONTROL_ALLOW_ORIGIN, $headers->get('access-control-allow-origin'));
        $this->assertEquals(CONTENT_TYPE_JSON, $headers->get('content-type'));
        $this->assertEquals(ACCESS_CONTROL_ALLOW_HEADERS, $headers->get('access-control-allow-headers'));
        $this->assertEquals(ACCESS_CONTROL_ALLOW_METHODS, $headers->get('access-control-allow-methods'));
    }

    public function request(string $method, string $url, array $inputData = [], $server = null)
    {
        return $this->client->request(
            $method,
            $url,
            [],
            [],
            $server ?? ['CONTENT_TYPE' => CONTENT_TYPE_JSON],
            json_encode($inputData)
        );
    }
}
