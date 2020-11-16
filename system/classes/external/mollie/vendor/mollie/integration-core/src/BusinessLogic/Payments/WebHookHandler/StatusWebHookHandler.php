<?php

namespace Mollie\BusinessLogic\Payments\WebHookHandler;

use Mollie\BusinessLogic\Integration\Interfaces\OrderTransitionService;
use Mollie\BusinessLogic\WebHook\PaymentChangedWebHookEvent;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class StatusWebHookHandler
 *
 * @package Mollie\BusinessLogic\Payments\WebHookHandler
 */
class StatusWebHookHandler
{
    /**
     * @var string[]
     */
    private static $STATUS_TO_SERVICE_METHOD = array(
        'paid' => 'payOrder',
        'expired' => 'expireOrder',
        'canceled' => 'cancelOrder',
        'authorized' => 'authorizeOrder',
        'failed' => 'failOrder',
    );

    /**
     * @param PaymentChangedWebHookEvent $event
     */
    public function handle(PaymentChangedWebHookEvent $event)
    {
        if ($event->getCurrentPayment()->getStatus() === $event->getNewPayment()->getStatus()) {
            return;
        }

        $serviceMethod = $this->getServiceMethodFor($event->getNewPayment()->getStatus());
        if (!$serviceMethod) {
            return;
        }

        call_user_func(
            array($this->getOrderTransitionService(), $serviceMethod),
            $event->getOrderReference()->getShopReference(),
            $event->getNewPayment()->getMetadata()
        );
    }

    /**
     * @param string $status
     *
     * @return string|null
     */
    protected function getServiceMethodFor($status)
    {
        return array_key_exists($status, static::$STATUS_TO_SERVICE_METHOD) ? static::$STATUS_TO_SERVICE_METHOD[$status] : null;
    }

    /**
     * @return OrderTransitionService
     */
    protected function getOrderTransitionService()
    {
        /** @var OrderTransitionService $orderTransitionService */
        $orderTransitionService = ServiceRegister::getService(OrderTransitionService::CLASS_NAME);
        return $orderTransitionService;
    }
}
