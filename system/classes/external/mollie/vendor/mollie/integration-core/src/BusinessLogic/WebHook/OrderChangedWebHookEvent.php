<?php

namespace Mollie\BusinessLogic\WebHook;

use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class OrderChangedWebHookEvent
 *
 * @package Mollie\BusinessLogic\WebHook
 */
class OrderChangedWebHookEvent extends Event
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * @var OrderReference
     */
    private $orderReference;
    /**
     * @var Order
     */
    private $currentOrder;
    /**
     * @var Order
     */
    private $newOrder;

    public function __construct(OrderReference $orderReference, Order $newOrder)
    {
        $this->orderReference = $orderReference;
        $this->currentOrder = Order::fromArray($orderReference->getPayload());
        $this->newOrder = $newOrder;
    }

    /**
     * @return OrderReference
     */
    public function getOrderReference()
    {
        return $this->orderReference;
    }

    /**
     * @return Order
     */
    public function getCurrentOrder()
    {
        return $this->currentOrder;
    }

    /**
     * @return Order
     */
    public function getNewOrder()
    {
        return $this->newOrder;
    }
}
