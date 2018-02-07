<?php

declare(strict_types=1);

namespace Modus\Test\Unit;

if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'test');
}

use PHPUnit\Framework\TestCase;
use ReflectionClass;

abstract class UnitTestCase extends TestCase
{
    /**
     * @param mixed $object
     *
     * @return mixed
     */
    protected function invokeMethodByReflection($object, string $method, array $arguments = null)
    {
        $reflectionClass = new ReflectionClass($object);
        $reflectionMethod = $reflectionClass->getMethod($method);
        $reflectionMethod->setAccessible(true);

        if (!is_null($arguments)) {
            return $reflectionMethod->invokeArgs($object, $arguments);
        } else {
            return $reflectionMethod->invoke($object);
        }
    }

    /**
     * @param mixed $object
     *
     * @return mixed
     */
    protected function getConstantByReflection($object, string $constant)
    {
        $reflectionClass = new ReflectionClass($object);

        return $reflectionClass->getConstant($constant);
    }
}