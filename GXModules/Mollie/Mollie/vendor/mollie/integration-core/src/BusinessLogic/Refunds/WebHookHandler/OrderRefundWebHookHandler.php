<?php

namespace Mollie\BusinessLogic\Refunds\WebHookHandler;

use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Integration\Interfaces\OrderTransitionService;
use Mollie\BusinessLogic\WebHook\PaymentChangedWebHookEvent;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class OrderRefundWebHookHandler
 *
 * @package Mollie\BusinessLogic\Refunds\WebHookHandler
 */
class OrderRefundWebHookHandler extends RefundWebHookHandler
{
    /**
     * @param PaymentChangedWebHookEvent $paymentChangedWebHookEvent
     */
    public function handle(PaymentChangedWebHookEvent $paymentChangedWebHookEvent)
    {
        $currentPayment = $paymentChangedWebHookEvent->getCurrentPayment();
        $currentEmbeddedData = $currentPayment->getEmbedded();
        $currentRefunds = $currentEmbeddedData['refunds'];
        $newPayment = $paymentChangedWebHookEvent->getNewPayment();
        $newEmbeddedData = $newPayment->getEmbedded();
        $newRefunds = $newEmbeddedData['refunds'];
        $currentRefundsMap = $this->createMapFromSource($currentRefunds);
        /** @var Refund $newRefund */
        foreach ($newRefunds as $newRefund) {
            if ($this->isRefundStatusChanged($currentRefundsMap, $newRefund)) {
                $this->processRefundStatusChanged(
                    $newRefund,
                    $newPayment,
                    $paymentChangedWebHookEvent->getOrderReference()->getShopReference()
                );
            }
        }
    }

    /**
     * @param Refund $refund
     * @param Payment $newPayment
     * @param string $shopReference
     */
    protected function processRefundStatusChanged(Refund $refund, $newPayment, $shopReference)
    {
        if (($refund->getStatus() === 'refunded') && $this->isFullyRefunded($newPayment)) {
            /** @var OrderTransitionService $service */
            $service = ServiceRegister::getService(OrderTransitionService::CLASS_NAME);
            $service->refundOrder($shopReference, $newPayment->getMetadata());
        }
    }

    /**
     * @param Payment $newPayment
     *
     * @return bool
     */
    protected function isFullyRefunded(Payment $newPayment)
    {
        return ((float)$newPayment->getAmountRefunded()->getAmountValue()) === ((float)$newPayment->getAmount()->getAmountValue());
    }
}
