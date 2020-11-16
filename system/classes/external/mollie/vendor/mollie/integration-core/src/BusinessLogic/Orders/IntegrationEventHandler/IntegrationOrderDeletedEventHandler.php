<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Integration\Event\IntegrationOrderDeletedEvent;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;
use Mollie\Infrastructure\ORM\Interfaces\RepositoryInterface;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class IntegrationOrderDeletedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderDeletedEventHandler
{
    /**
     * @param IntegrationOrderDeletedEvent $event
     *
     * @throws RepositoryNotRegisteredException
     */
    public function handle(IntegrationOrderDeletedEvent $event)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        if ($orderReference = $orderReferenceService->getByShopReference($event->getShopReference())) {
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.integration.event.notification.order_deleted.title'),
                new NotificationText('mollie.payment.integration.event.notification.order_deleted.description'),
                $event->getShopReference()
            );

            /** @var RepositoryInterface $repository */
            $repository = RepositoryRegistry::getRepository(OrderReference::CLASS_NAME);
            $repository->delete($orderReference);
        }
    }
}
