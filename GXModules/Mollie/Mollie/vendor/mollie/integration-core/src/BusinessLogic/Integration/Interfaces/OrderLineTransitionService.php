<?php

namespace Mollie\BusinessLogic\Integration\Interfaces;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;

/**
 * Interface OrderLineTransitionService
 *
 * @package Mollie\BusinessLogic\Integration\Interfaces
 */
interface OrderLineTransitionService
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Sets integration order line status to paid
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param OrderLine $newOrderLine New order line data
     */
    public function payOrderLine($orderId, OrderLine $newOrderLine);

    /**
     * Sets integration order line status to canceled
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param OrderLine $newOrderLine New order line data
     */
    public function cancelOrderLine($orderId, OrderLine $newOrderLine);

    /**
     * Sets integration order line status to authorized
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param OrderLine $newOrderLine New order line data
     */
    public function authorizeOrderLine($orderId, OrderLine $newOrderLine);

    /**
     * Sets integration order line status to completed
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param OrderLine $newOrderLine New order line data
     */
    public function completeOrderLine($orderId, OrderLine $newOrderLine);

    /**
     * Sets integration order line status to refunded
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param OrderLine $newOrderLine New order line data
     *
     * @return mixed
     */
    public function refundOrderLine($orderId, OrderLine $newOrderLine);
}
