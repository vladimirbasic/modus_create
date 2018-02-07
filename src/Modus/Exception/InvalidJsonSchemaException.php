<?php

namespace Modus\Exception;

use Exception;
use Throwable;

class InvalidJsonSchemaException extends Exception
{
    /**
     * @var array
     */
    private $messages;

    public function __construct(
        array $messages = [],
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct('Invalid JSON Schema', $code, $previous);
        $this->messages = $messages;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}
