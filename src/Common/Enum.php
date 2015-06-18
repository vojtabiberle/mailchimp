<?php

namespace Mailchimp\Common;

use Mailchimp\Exception\RuntimeException;

class Enum implements \JsonSerializable
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

    /**
     * (PHP 5 &gt;= 5.4.0)<br/>
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     */
    function jsonSerialize()
    {
        return $this->value;
    }
}