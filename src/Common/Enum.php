<?php

namespace Mailchimp\Common;

use Mailchimp\Exception\RuntimeException;

class Enum
{
    private $availableValues;

    private $value;

    public function __construct($availableValues)
    {
        $this->availableValues = $availableValues;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        if (!in_array($value, $this->availableValues, true)) {
            throw new RuntimeException('Value "'.$value.'" is not permited. Available values are ['.implode(',', $this->availableValues).']');
        }
        $this->value = $value;
    }

}