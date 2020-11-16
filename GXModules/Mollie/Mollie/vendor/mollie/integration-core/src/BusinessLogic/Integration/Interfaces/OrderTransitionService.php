<?php

namespace Mollie\BusinessLogic\Integration\Interfaces;

/**
 * Interface OrderTransitionService
 *
 * @package Mollie\BusinessLogic\Integration\Interfaces
 */
interface OrderTransitionService
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Sets integration order status to paid
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function payOrder($orderId, array $metadata);

    /**
     * Sets integration order status to expired
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function expireOrder($orderId, array $metadata);

    /**
     * Sets integration order status to canceled
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function cancelOrder($orderId, array $metadata);

    /**
     * Sets integration order status to failed
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function failOrder($orderId, array $metadata);

    /**
     * Sets integration order status to completed
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function completeOrder($orderId, array $metadata);

    /**
     * Sets integration order status to authorized
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function authorizeOrder($orderId, array $metadata);

    /**
     * Sets integration order status to refunded
     *
     * @param string $orderId Integration order unique identifier used during payment creation
     * @param array $metadata Metadata provided by integration during payment creation
     */
    public function refundOrder($orderId, array $metadata);
}
