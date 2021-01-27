<?php

namespace Mollie\BusinessLogic\Orders\WebHookHandler;

use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Integration\Interfaces\OrderTransitionService;
use Mollie\BusinessLogic\WebHook\OrderChangedWebHookEvent;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class StatusWebHookHandler
 *
 * @package Mollie\BusinessLogic\Orders\WebHookHandler
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
        'completed' => 'completeOrder',
    );

    /**
     * @var string[]
     */
    private static $ORDER_PAYMENT_STATUS_TO_SERVICE_METHOD = array(
        'expired' => 'expireOrder',
        'canceled' => 'cancelOrder',
        'failed' => 'failOrder',
    );

    /**
     * @param OrderChangedWebHookEvent $event
     */
    public function handle(OrderChangedWebHookEvent $event)
    {
        if (!$this->isOrderStatusChanged($event)) {
            $this->handlePaymentStatusChanges($event);
            return;
        }

        $serviceMethod = $this->getServiceMethodFor($event->getNewOrder()->getStatus());
        if (!$serviceMethod) {
            return;
        }

        $this->handleOrderLineChanges($event);

        call_user_func(
            array($this->getOrderTransitionService(), $serviceMethod),
            $event->getOrderReference()->getShopReference(),
            $event->getNewOrder()->getMetadata()
        );
    }

    /**
     * @param OrderChangedWebHookEvent $event
     *
     * @return bool
     */
    protected function isOrderStatusChanged(OrderChangedWebHookEvent $event)
    {
        $currentStatus = $event->getCurrentOrder()->getStatus();
        $newStatus = $event->getNewOrder()->getStatus();
        // check for initial state transition
        if ($currentStatus === null && $newStatus === 'created') {
            return false;
        }

        return $currentStatus !== $newStatus;
    }

    /**
     * @param OrderChangedWebHookEvent $event
     */
    protected function handlePaymentStatusChanges(OrderChangedWebHookEvent $event)
    {
        $currentEmbeds = $event->getCurrentOrder()->getEmbedded();
        $newEmbeds = $event->getNewOrder()->getEmbedded();
        if (empty($currentEmbeds['payments']) || empty($newEmbeds['payments'])) {
            return;
        }

        /** @var Payment[] $currentOrderPaymentMap */
        $currentOrderPaymentMap = array();
        /** @var Payment[] $currentPayments */
        $currentPayments = $currentEmbeds['payments'];
        foreach ($currentPayments as $currentPayment) {
            $currentOrderPaymentMap[$currentPayment->getId()] = $currentPayment;
        }

        /** @var Payment[] $newPayments */
        $newPayments = $newEmbeds['payments'];
        foreach ($newPayments as $newPayment) {
            if (!array_key_exists($newPayment->getId(), $currentOrderPaymentMap)) {
                continue;
            }

            if ($currentOrderPaymentMap[$newPayment->getId()]->getStatus() === $newPayment->getStatus()) {
                continue;
            }

            $serviceMethod = $this->getOrderPaymentServiceMethodFor($newPayment->getStatus());
            if (!$serviceMethod) {
                continue;
            }

            call_user_func(
                array($this->getOrderTransitionService(), $serviceMethod),
                $event->getOrderReference()->getShopReference(),
                $event->getNewOrder()->getMetadata()
            );
        }
    }

    /**
     * @param OrderChangedWebHookEvent $event
     */
    protected function handleOrderLineChanges(OrderChangedWebHookEvent $event)
    {
        $lineHandler = new LineStatusWebHookHandler();
        $lineHandler->handle($event, true);
    }

    /**
     * @param string $status
     *
     * @return string|null
     */
    protected function getServiceMethodFor($status)
    {
        if (array_key_exists($status, static::$STATUS_TO_SERVICE_METHOD)) {
            return static::$STATUS_TO_SERVICE_METHOD[$status];
        }

        return null;
    }

    /**
     * @param $status
     *
     * @return string|null
     */
    protected function getOrderPaymentServiceMethodFor($status)
    {
        if (array_key_exists($status, static::$ORDER_PAYMENT_STATUS_TO_SERVICE_METHOD)) {
            return static::$ORDER_PAYMENT_STATUS_TO_SERVICE_METHOD[$status];
        }

        return null;
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
