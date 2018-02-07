<?php

namespace ModusTest\Unit\Model\VehicleValueObject;

use Modus\Exception\CurlAdapterException;
use Modus\Library\CurlAdapter;
use Modus\Test\Unit\UnitTestCase;

class SendRequestTest extends UnitTestCase
{
    public function testMethod()
    {
        // arrange
        $curlAdapter = new CurlAdapter();
        ;$this->expectException(CurlAdapterException::class);
        $this->expectExceptionMessage('<url> malformed');

        // act
        $curlAdapter->sendRequest('', []);
    }
}