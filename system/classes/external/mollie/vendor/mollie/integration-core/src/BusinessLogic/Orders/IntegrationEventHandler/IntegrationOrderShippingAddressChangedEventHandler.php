<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Integration\Event\IntegrationOrderShippingAddressChangedEvent;
use Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException;

/**
 * Class IntegrationOrderShippingAddressChangedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderShippingAddressChangedEventHandler extends IntegrationOrderAddressChangedEventHandler
{
    /**
     * @param IntegrationOrderShippingAddressChangedEvent $event
     *
     * @throws \Exception
     */
    public function handle(IntegrationOrderShippingAddressChangedEvent $event)
    {
        try {
            $this->getOrderService()->updateShippingAddress($event->getShopReference(), $event->getShippingAddress());
        } catch (ReferenceNotFoundException $exception) {

        } catch (\Exception $exception) {
            $this->handleAddressUpdateError($event, $exception, static::SHIPPING_ADDRESS);
        }
    }
}
