<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Integration\Event\IntegrationOrderBillingAddressChangedEvent;
use Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException;

/**
 * Class IntegrationOrderBillingAddressChangedEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderBillingAddressChangedEventHandler extends IntegrationOrderAddressChangedEventHandler
{
    /**
     * @param IntegrationOrderBillingAddressChangedEvent $event
     *
     * @throws \Exception
     */
    public function handle(IntegrationOrderBillingAddressChangedEvent $event)
    {
        try {
            $this->getOrderService()->updateBillingAddress($event->getShopReference(), $event->getBillingAddress());
        } catch (ReferenceNotFoundException $exception) {

        } catch (\Exception $exception) {
            $this->handleAddressUpdateError($event, $exception, static::BILLING_ADDRESS);
        }
    }
}
