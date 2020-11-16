<?php

namespace Mollie\BusinessLogic\Http\DTO\Orders;

use Mollie\BusinessLogic\Http\DTO\BaseDto;

/**
 * Class Tracking
 *
 * @package Mollie\BusinessLogic\Http\DTO\Orders
 */
class Tracking extends BaseDto
{
    /**
     * @var string
     */
    protected $carrier;
    /**
     * @var string
     */
    protected $code;
    /**
     * @var string|null
     */
    protected $url;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $raw)
    {
        $result = new static();

        $result->carrier = static::getValue($raw, 'carrier');
        $result->code = static::getValue($raw, 'code');
        $result->url = static::getValue($raw, 'url', null);

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $result = array(
            'carrier' => $this->carrier,
            'code' => $this->code,
        );

        if ($this->url) {
            $result['url'] = $this->url;
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getCarrier()
    {
        return $this->carrier;
    }

    /**
     * @param string $carrier
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}