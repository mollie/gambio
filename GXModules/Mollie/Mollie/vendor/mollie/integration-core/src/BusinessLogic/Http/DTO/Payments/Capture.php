<?php

namespace Mollie\BusinessLogic\Http\DTO\Payments;

use Mollie\BusinessLogic\Http\DTO\BaseDto;

/**
 * Class Capture
 *
 * @package Mollie\BusinessLogic\Http\DTO\Payments
 */
class Capture extends BaseDto
{
    /**
     * @var string
     */
    protected $description;
    /**
     * @var Amount|null
     */
    protected $amount;
    /**
     * @var array
     */
    protected $metadata;

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return Amount|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Amount|null $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @param array $raw
     *
     * @return Capture
     */
    public static function fromArray(array $raw)
    {
        $capture = new static();
        $capture->setDescription(static::getValue($raw, 'description'));
        $capture->setAmount(Amount::fromArray(static::getValue($raw, 'amount', null)));
        $capture->setMetadata(static::getValue($raw, 'metadata'));

        return $capture;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'description' => $this->getDescription(),
            'amount' => $this->getAmount() ? $this->getAmount()->toArray() : null,
            'metadata' => $this->getMetadata()
        );
    }
}
