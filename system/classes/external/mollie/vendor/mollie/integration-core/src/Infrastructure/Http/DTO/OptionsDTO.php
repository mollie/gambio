<?php

namespace Mollie\Infrastructure\Http\DTO;

/**
 * Class OptionsDTO. Represents HTTP options set for Request by HttpClient.
 *
 * @package Mollie\Infrastructure\Http\DTO
 */
class OptionsDTO
{
    /**
     * Name of the option.
     *
     * @var string
     */
    private $name;
    /**
     * Value of the option.
     *
     * @var string
     */
    private $value;

    /**
     * OptionsDTO constructor.
     *
     * @param string $name Name of the option.
     * @param string $value Value of the option.
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Gets name of the option.
     *
     * @return string Name of the option.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets value of the option.
     *
     * @return string Value of the option.
     */
    public function getValue()
    {
        return $this->value;
    }
}
