<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Integration\Event\IntegrationOrderTotalChangedEvent;
use Mollie\BusinessLogic\Integration\Exceptions\OperationNotSupportedException;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class IntegrationOrderTotalChangedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderTotalChangedEventHandler
{

    /**
     * @param IntegrationOrderTotalChangedEvent $event
     *
     * @throws OperationNotSupportedException
     */
    public function handle(IntegrationOrderTotalChangedEvent $event)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        if ($orderReferenceService->getByShopReference($event->getShopReference())) {
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.integration.event.notification.order_total_changed.title'),
                new NotificationText('mollie.payment.integration.event.notification.order_total_changed.description'),
                $event->getShopReference()
            );

            throw new OperationNotSupportedException('Order total change is not supported on Mollie');
        }
    }
}
