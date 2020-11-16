<?php

namespace Mollie\BusinessLogic\Integration\Event;

use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class IntegrationOrderChangedEvent
 *
 * @package Mollie\BusinessLogic\Integration\Event
 */
class IntegrationOrderChangedEvent extends Event
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    const ORDER_TOTAL_CHANGED = 'order_total_changed';
    const ORDER_DELETED = 'order_deleted';
    const ORDER_CLOSED = 'order_closed';
    const ORDER_UPDATED = 'order_updated';

    /**
     * @var string
     */
    private $shopReference;
    /**
     * @var string
     */
    private $type;
    /**
     * @var Order
     */
    private $orderForUpdate;

    /**
     * IntegrationOrderChangedEvent constructor.
     *
     * @param string $shopReference
     * @param string $type
     * @param Order $orderForUpdate
     */
    public function __construct($shopReference, $type, Order $orderForUpdate = null)
    {
        $this->shopReference = $shopReference;
        $this->type = $type;
        $this->orderForUpdate = $orderForUpdate;
    }

    /**
     * @return string
     */
    public function getShopReference()
    {
        return $this->shopReference;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Order
     */
    public function getOrderForUpdate()
    {
        return $this->orderForUpdate;
    }
}
