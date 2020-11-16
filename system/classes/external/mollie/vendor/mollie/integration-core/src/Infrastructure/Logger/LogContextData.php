<?php

namespace Mollie\Infrastructure\Logger;

/**
 * Class LogContextData.
 *
 * @package Mollie\Infrastructure\Logger
 */
class LogContextData
{
    /**
     * Name of data.
     *
     * @var string
     */
    private $name;
    /**
     * Value of data.
     *
     * @var mixed
     */
    private $value;

    /**
     * LogContextData constructor.
     *
     * @param string $name Name of data.
     * @param mixed $value Value of data.
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Gets name of data.
     *
     * @return string Name of data.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets value of data.
     *
     * @return mixed Value of data.
     */
    public function getValue()
    {
        return $this->value;
    }
}
