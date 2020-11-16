<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;

/**
 * Class OrderLineTransitionService
 *
 * @package Mollie\Gambio\Services\Business
 */
class OrderLineTransitionService implements \Mollie\BusinessLogic\Integration\Interfaces\OrderLineTransitionService
{

    /**
     * {@inheritdoc}
     */
    public function payOrderLine($orderId, OrderLine $newOrderLine)
    {
        // Intentionally left blank. For gambio integration this method is null operation
    }

    /**
     * {@inheritdoc}
     */
    public function cancelOrderLine($orderId, OrderLine $newOrderLine)
    {
        NotificationHub::pushInfo(
            new NotificationText('mollie.payment.webhook.notification.order_line_cancel_info.title'),
            new NotificationText('mollie.payment.webhook.notification.order_line_cancel_info.description'),
            $orderId
        );
    }

    /**
     * {@inheritdoc}
     */
    public function authorizeOrderLine($orderId, OrderLine $newOrderLine)
    {
        // Intentionally left blank. For gambio integration this method is null operation
    }

    /**
     * {@inheritdoc}
     */
    public function completeOrderLine($orderId, OrderLine $newOrderLine)
    {
        // Intentionally left blank. For gambio integration this method is null operation
    }

    /**
     * {@inheritdoc}
     *
     * @param string $orderId
     * @param OrderLine $newOrderLine
     *
     * @return mixed|void
     */
    public function refundOrderLine($orderId, OrderLine $newOrderLine)
    {
        NotificationHub::pushInfo(
            new NotificationText('mollie.payment.webhook.notification.order_line_refund_info.title'),
            new NotificationText('mollie.payment.webhook.notification.order_line_refund_info.description'),
            $orderId
        );
    }
}