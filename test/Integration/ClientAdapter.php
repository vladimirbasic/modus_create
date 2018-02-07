<?php

declare(strict_types=1);

namespace Modus\Test\Integration;

use BadMethodCallException;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\DomCrawler\Crawler;

class ClientAdapter
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request(
        $method,
        $uri,
        array $parameters = [],
        array $files = [],
        array $server = [],
        $content = null,
        $changeHistory = true
    ): Crawler {
        return $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
    }

    public function getResponse()
    {
        return $this->client->getResponse();
    }

    public function __call(string $name, array $arguments): Crawler
    {
        // allow only POST, PUT, GET, DELETE method names
        $allowedMethods = [HTTP_METHOD_POST, HTTP_METHOD_PUT, HTTP_METHOD_GET, HTTP_METHOD_DELETE];
        if (!in_array(strtoupper($name), $allowedMethods, true)) {
            throw new BadMethodCallException("Method '$name' is undefined");
        }

        // prepare params the way Client request method accepts it
        $parameters = [
            strtoupper($name),
            $arguments[0],
            [],
            [],
            $arguments[2] ?? ['CONTENT_TYPE' => CONTENT_TYPE_JSON],
            isset($arguments[1]) ? json_encode($arguments[1]) : null,
        ];

        return call_user_func_array([$this->client, 'request'], $parameters);
    }
}