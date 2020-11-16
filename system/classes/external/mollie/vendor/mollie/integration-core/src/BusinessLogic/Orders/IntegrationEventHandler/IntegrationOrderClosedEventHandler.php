<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderClosedEvent;
use Mollie\BusinessLogic\Integration\Exceptions\OperationNotSupportedException;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class IntegrationOrderClosedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderClosedEventHandler
{
    /**
     * @param IntegrationOrderClosedEvent $event
     *
     * @throws OperationNotSupportedException
     */
    public function handle(IntegrationOrderClosedEvent $event)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        $orderReference = $orderReferenceService->getByShopReference($event->getShopReference());
        if ($this->isActionRequired($orderReference)) {
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.integration.event.notification.order_closed.title'),
                new NotificationText('mollie.payment.integration.event.notification.order_closed.description'),
                $event->getShopReference()
            );

            throw new OperationNotSupportedException('Closing an order which is not completed is not supported');
        }
    }

    /**
     * Check if notification should be pushed
     *
     * @param OrderReference $orderReference
     *
     * @return bool
     */
    protected function isActionRequired($orderReference)
    {
        if ($orderReference === null) {
            return false;
        }

        if ($orderReference->getApiMethod() === PaymentMethodConfig::API_METHOD_ORDERS) {
            $order = Order::fromArray($orderReference->getPayload());

            return  $order->getStatus() !== 'completed';
        }

        return true;
    }
}
