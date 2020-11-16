<?php

namespace Mollie\Infrastructure\ORM\Configuration;

use InvalidArgumentException;

/**
 * Represents an indexed column in database table.
 *
 * @package Mollie\Infrastructure\ORM\Configuration
 */
class Index
{
    /**
     * Boolean index type.
     */
    const BOOLEAN = 'boolean';
    /**
     * DateTime index type.
     */
    const DATETIME = 'dateTime';
    /**
     * Double number index type.
     */
    const DOUBLE = 'double';
    /**
     * Integer number index type.
     */
    const INTEGER = 'integer';
    /**
     * String index type.
     */
    const STRING = 'string';
    /**
     * Index type.
     *
     * @var string
     */
    private $type;
    /**
     * Property name (column name).
     *
     * @var string
     */
    private $property;

    /**
     * Index constructor.
     *
     * @param string $type Type of index. User this class constants for types.
     * @param string $property Column name.
     */
    public function __construct($type, $property)
    {
        if (!in_array($type, array(self::BOOLEAN, self::DATETIME, self::DOUBLE, self::INTEGER, self::STRING), true)) {
            throw new InvalidArgumentException("Invalid index type given: $type.");
        }

        $this->type = $type;
        $this->property = $property;
    }

    /**
     * Returns property name.
     *
     * @return string Property name.
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Returns index field type.
     *
     * @return string Field type.
     */
    public function getType()
    {
        return $this->type;
    }
}
