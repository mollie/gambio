<?php

namespace Mollie\BusinessLogic\Http\DTO\Payments;

use Mollie\BusinessLogic\Http\DTO\BaseDto;

/**
 * Class Amount
 *
 * @package Mollie\BusinessLogic\Http\DTO\Payments
 */
class Amount extends BaseDto
{
    /**
     * @var string
     */
    protected $currency;
    /**
     * @var string
     */
    protected $value;

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getValueAmount()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
          'currency' => $this->getCurrency(),
          'value' => $this->getValueAmount()
        );
    }

    /**
     * @param array $raw
     * @return Amount
     */
    public static function fromArray(array $raw)
    {
        $amount = new static();
        $amount->setCurrency(static::getValue($raw, 'currency'));
        $amount->setValue(static::getValue($raw, 'value'));

        return $amount;
    }
}
