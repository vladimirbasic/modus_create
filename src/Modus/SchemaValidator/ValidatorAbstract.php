<?php

namespace Modus\SchemaValidator;

use InvalidArgumentException;
use JsonSchema\Validator;
use Modus\Exception\InvalidJsonSchemaException;

abstract class ValidatorAbstract
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @var string
     */
    protected $schema;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws InvalidArgumentException
     * @throws InvalidJsonSchemaException
     */
    public function __invoke(string $data): void
    {
        $data = (object)json_decode($data);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON');
        }

        $this->validator->validate($data, (object)json_decode($this->schema));
        if (!$this->validator->isValid()) {
            $messages = [];
            foreach ($this->validator->getErrors() as $error) {
                $messages[] = 'Field [' . $error['property'] . ']: ' . $error['message'];
            }
            throw new InvalidJsonSchemaException($messages);
        }
    }
}
