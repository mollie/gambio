<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Integration\Event\IntegrationOrderShippedEvent;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException;
use Mollie\BusinessLogic\Shipments\ShipmentService;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class IntegrationOrderShippedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderShippedEventHandler
{
    /**
     * @param IntegrationOrderShippedEvent $event
     *
     * @throws \Exception
     */
    public function handle(IntegrationOrderShippedEvent $event)
    {
        /** @var ShipmentService $shipmentService */
        $shipmentService = ServiceRegister::getService(ShipmentService::CLASS_NAME);
        try {
            $shipmentService->shipOrder(
                $event->getShopOrderReference(),
                $event->getTracking(),
                $event->getLineItems()
            );
        } catch (ReferenceNotFoundException $e) {
            // Intentionally left blank. Not existing shop reference should be skipped silently
        } catch (\Exception $e) {
            Logger::logError(
                'Failed to create mollie order shipment.',
                'Core',
                array(
                    'ShopOrderReference' => $event->getShopOrderReference(),
                    'TrackingData' => $event->getTracking() ? $event->getTracking()->toArray() : null,
                    'ExceptionMessage' => $e->getMessage(),
                    'ExceptionTrace' => $e->getTraceAsString(),
                )
            );
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.integration.event.notification.order_ship_error.title'),
                new NotificationText(
                    'mollie.payment.integration.event.notification.order_ship_error.description',
                    array('api_message' => $e->getMessage())
                ),
                $event->getShopOrderReference()
            );

            throw $e;
        }
    }
}
