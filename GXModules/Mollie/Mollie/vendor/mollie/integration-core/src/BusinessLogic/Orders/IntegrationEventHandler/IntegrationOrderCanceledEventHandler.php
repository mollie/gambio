<?php

namespace Mollie\BusinessLogic\Orders\IntegrationEventHandler;

use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderCanceledEvent;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class IntegrationOrderCanceledEventHandler
 *
 * @package Mollie\BusinessLogic\Orders\IntegrationEventHandler
 */
class IntegrationOrderCanceledEventHandler
{
    /**
     * @param IntegrationOrderCanceledEvent $event
     *
     * @throws \Exception
     */
    public function handle(IntegrationOrderCanceledEvent $event)
    {
        try {
            /** @var OrderReferenceService $orderReferenceService */
            $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
            $shopReference = $event->getShopOrderReference();
            $orderReference = $orderReferenceService->getByShopReference($shopReference);
            if ($orderReference) {
                /** @var Proxy $proxy */
                $proxy = ServiceRegister::getService(Proxy::CLASS_NAME);
                $mollieReference = $orderReference->getMollieReference();
                if ($orderReference->getApiMethod() === PaymentMethodConfig::API_METHOD_PAYMENT) {
                    $proxy->cancelPayment($mollieReference);

                    return;
                }

                $proxy->cancelOrder($mollieReference);
            }
        } catch (\Exception $e) {
            $this->handleOrderCancelError($event, $e);
        }
    }

    /**
     * @param IntegrationOrderCanceledEvent $event
     * @param \Exception $e
     *
     * @throws \Exception
     */
    protected function handleOrderCancelError(IntegrationOrderCanceledEvent $event, \Exception $e)
    {
        Logger::logError(
            'Failed to cancel mollie order.',
            'Core',
            array(
                'ShopOrderReference' => $event->getShopOrderReference(),
                'ExceptionMessage' => $e->getMessage(),
                'ExceptionTrace' => $e->getTraceAsString(),
            )
        );
        NotificationHub::pushInfo(
            new NotificationText('mollie.payment.integration.event.notification.order_cancel_error.title'),
            new NotificationText(
                'mollie.payment.integration.event.notification.order_cancel_error.description',
                array('api_message' => $e->getMessage())
            ),
            $event->getShopOrderReference()
        );

        throw $e;
    }
}
