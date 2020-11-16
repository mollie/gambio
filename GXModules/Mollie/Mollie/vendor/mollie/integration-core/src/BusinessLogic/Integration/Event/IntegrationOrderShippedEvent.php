<?php

namespace Mollie\BusinessLogic\Integration\Event;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Orders\Tracking;
use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class IntegrationOrderShippedEvent
 *
 * @package Mollie\BusinessLogic\Integration\Event
 */
class IntegrationOrderShippedEvent extends Event
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $shopOrderReference;
    /**
     * @var Tracking|null
     */
    private $tracking;
    /**
     * @var OrderLine[]
     */
    private $lineItems;

    /**
     * IntegrationOrderShippedEvent constructor.
     *
     * @param string $shopOrderReference Unique identifier of a shop order
     * @param Tracking|null $tracking
     * @param array $items
     */
    public function __construct($shopOrderReference, $tracking = null, $items = array())
    {
        $this->shopOrderReference = $shopOrderReference;
        $this->tracking = $tracking;
        $this->lineItems = $items;
    }

    /**
     * @return string
     */
    public function getShopOrderReference()
    {
        return $this->shopOrderReference;
    }

    /**
     * @return Tracking|null
     */
    public function getTracking()
    {
        return $this->tracking;
    }

    /**
     * @return OrderLine[]
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }
}