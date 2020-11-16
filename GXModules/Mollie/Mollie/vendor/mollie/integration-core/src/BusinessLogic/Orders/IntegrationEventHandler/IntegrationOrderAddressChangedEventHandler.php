<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class IntegrationOrderAddressChangedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
abstract class IntegrationOrderAddressChangedEventHandler
{
    const SHIPPING_ADDRESS = 'shipping';
    const BILLING_ADDRESS = 'billing';

    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @param Event $event
     * @param \Exception $e
     *
     * @param $addressType
     *
     * @throws \Exception
     */
    protected function handleAddressUpdateError(Event $event, \Exception $e, $addressType)
    {
        Logger::logError(
            'Failed to update address.',
            'Core',
            array(
                'ShopOrderReference' => $event->getShopReference(),
                'ExceptionMessage' => $e->getMessage(),
                'ExceptionTrace' => $e->getTraceAsString(),
            )
        );
        NotificationHub::pushInfo(
            new NotificationText("mollie.payment.integration.event.notification.{$addressType}_address_change_error.title"),
            new NotificationText(
                "mollie.payment.integration.event.notification.{$addressType}_address_change_error.description",
                array('api_message' => $e->getMessage())
            ),
            $event->getShopReference()
        );

        throw $e;
    }

    /**
     * @return OrderService
     */
    protected function getOrderService()
    {
        if ($this->orderService === null) {
            $this->orderService = ServiceRegister::getService(OrderService::CLASS_NAME);
        }

        return $this->orderService;
    }
}
