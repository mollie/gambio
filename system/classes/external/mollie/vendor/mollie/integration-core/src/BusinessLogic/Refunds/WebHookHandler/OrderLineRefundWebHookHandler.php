<?php

namespace Mollie\BusinessLogic\Refunds\WebHookHandler;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Integration\Interfaces\OrderLineTransitionService;
use Mollie\BusinessLogic\Integration\Interfaces\OrderTransitionService;
use Mollie\BusinessLogic\WebHook\OrderChangedWebHookEvent;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class OrderLineRefundWebHookHandler
 *
 * @package Mollie\BusinessLogic\Refunds\WebHookHandler
 */
class OrderLineRefundWebHookHandler extends RefundWebHookHandler
{
    /**
     * @param OrderChangedWebHookEvent $orderChangedWebHookEvent
     */
    public function handle(OrderChangedWebHookEvent $orderChangedWebHookEvent)
    {
        $shopReference = $orderChangedWebHookEvent->getOrderReference()->getShopReference();
        $currentOrder = $orderChangedWebHookEvent->getCurrentOrder();
        $currentEmbeddedData = $currentOrder->getEmbedded();
        $currentRefunds = $currentEmbeddedData['refunds'];
        $newOrder = $orderChangedWebHookEvent->getNewOrder();
        $newEmbeddedData = $newOrder->getEmbedded();
        $newRefunds = $newEmbeddedData['refunds'];
        $currentRefundsMap = $this->createMapFromSource($currentRefunds);
        $newOrderLinesMap = $this->createMapFromSource($newOrder->getLines());

        /** @var Refund $newRefund */
        foreach ($newRefunds as $newRefund) {
            if ($this->isRefundStatusChanged($currentRefundsMap, $newRefund)) {
                $this->processRefundStatusChanged($newOrderLinesMap, $newRefund, $shopReference);
            }
        }

        if ($this->checkIfAllItemsAreReturned($newOrderLinesMap, $newRefunds)) {
            ServiceRegister::getService(OrderTransitionService::CLASS_NAME)->refundOrder($shopReference, $newOrder->getMetadata());
        }
    }

    /**
     * @param array $newOrderLinesMap
     * @param Refund $refund
     * @param string $shopReferenceId
     */
    protected function processRefundStatusChanged($newOrderLinesMap, Refund $refund, $shopReferenceId)
    {
        if ($refund->getStatus() === 'refunded') {
            /** @var OrderLineTransitionService $service */
            $service = ServiceRegister::getService(OrderLineTransitionService::CLASS_NAME);
            /** @var OrderLine $refundLine */
            foreach ($refund->getLines() as $refundLine) {
                $lineId = $refundLine->getId();
                if (array_key_exists($lineId, $newOrderLinesMap)) {
                    $service->refundOrderLine($shopReferenceId, $newOrderLinesMap[$lineId]);
                }
            }
        }
    }

    /**
     * Check if refunded quantity matches ordered quantity
     *
     * @param OrderLine[] $newOrderLinesMap
     * @param Refund[] $refunds
     *
     * @return bool
     */
    protected function checkIfAllItemsAreReturned($newOrderLinesMap, $refunds)
    {
        $refundedLinesMap = $this->initRefundedLinesMap(array_keys($newOrderLinesMap));
        foreach ($refunds as $refund) {
            if ($refund->getStatus() === 'refunded') {
                foreach ($refund->getLines() as $refundLine) {
                    $refundedLinesMap[$refundLine->getId()] += $refundLine->getQuantity();
                }
            }
        }
        foreach ($refundedLinesMap as $lineId => $quantityRefunded) {
            /** @var OrderLine $line */
            $line = $newOrderLinesMap[$lineId];
            if (((int)$line->getQuantity()) !== $quantityRefunded) {
                return false;
            }
        }

        return true;
    }

    /**
     * Initialize refundedLinesMap [$lineId => 0]
     *
     * @param array $lineIds
     *
     * @return array
     */
    protected function initRefundedLinesMap(array $lineIds)
    {
        $refundedLinesMap = array();
        foreach ($lineIds as $lineId) {
            $refundedLinesMap[$lineId] = 0;
        }

        return $refundedLinesMap;
    }
}
