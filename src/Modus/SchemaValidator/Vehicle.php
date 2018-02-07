<?php

namespace Modus\SchemaValidator;

use JsonSchema\Validator;

class Vehicle extends ValidatorAbstract
{
    /**
     * @var string
     */
    protected $schema;

    public function __construct(Validator $validator)
    {
        parent::__construct($validator);

        $currentYear = date('Y');
        $this->schema = '
{
    "title": "Meal",
    "type": "object",
    "properties": {
        "modelYear": {
            "type": "number",
            "minimum": 1900,
            "maximum": ' . $currentYear . '
        },
        "manufacturer": {
            "type": "string",
            "minLength": 2,
            "maxLength": 30
        },
        "model": {
            "type": "string",
            "minLength": 2,
            "maxLength": 30
        }
    },
    "required": ["modelYear", "manufacturer", "model"],
    "additionalProperties": false
}';
    }
}
