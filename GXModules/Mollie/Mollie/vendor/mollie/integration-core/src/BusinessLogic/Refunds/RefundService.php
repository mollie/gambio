<?php

namespace Mollie\BusinessLogic\Refunds;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\BusinessLogic\Refunds\Exceptions\RefundNotAllowedException;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class RefundService
 *
 * @package Mollie\BusinessLogic\Refunds
 */
class RefundService extends BaseService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Refunds payment
     *
     * @param string|int $shopReference unique identifier of shop order
     * @param Refund $refund Refund object
     *
     * @return Refund|null
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     */
    public function refundPayment($shopReference, Refund $refund)
    {
        if ($orderReference = $this->getOrderReference($shopReference)) {
            return $this->getProxy()->createPaymentRefund($refund, $orderReference->getMollieReference());
        }

        throw new ReferenceNotFoundException("An error during payment refund occurred: order reference not found. Shop reference: {$shopReference}");
    }

    /**
     * Refunds order lines
     *
     * @param string|int $shopReference unique identifier of shop order
     * @param Refund $refund Refund object
     *
     * @return Refund|null
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     * @throws ReferenceNotFoundException
     */
    public function refundOrderLines($shopReference, Refund $refund)
    {
        /** @var OrderService $orderService */
        $orderService = ServiceRegister::getService(OrderService::CLASS_NAME);
        if ($existingOrder = $orderService->getOrder($shopReference)) {
            // ensure idempotent Order object
            if ($this->allItemsRefunding(Order::fromArray($existingOrder->toArray()), $refund->getRefundLinesMap())) {
                $refund->setLines(array());
            }

            return $this->getProxy()->createOrderLinesRefund($refund, $existingOrder->getId());
        }

        throw new ReferenceNotFoundException("An error during order line refund occurred: order reference not found. Shop reference: {$shopReference}");
    }

    /**
     * Refunds order
     *
     * @param string|int $shopReference unique identifier of shop order
     * @param Refund $refund Refund object
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws RefundNotAllowedException
     * @throws UnprocessableEntityRequestException
     * @throws ReferenceNotFoundException
     */
    public function refundWholeOrder($shopReference, Refund $refund)
    {
        $order = OrderService::getInstance()->getOrder($shopReference);
        if (!$order->getId()) {
            return;
        }

        $refundablePayments = $this->getRefundablePayments($order);
        $amountValueToRefund = (float)$refund->getAmount()->getAmountValue();
        $this->checkIfRefundIsPossible($amountValueToRefund, $order);
        $index = 0;
        while ($amountValueToRefund > 0) {
            /** @var Payment $existingPayment */
            $existingPayment = $refundablePayments[$index];
            $paymentForRefund = new Refund();
            $amountToRefund = $this->getAmountForRefund($amountValueToRefund, $existingPayment->getAmount());
            $paymentForRefund->setAmount($amountToRefund);
            $paymentForRefund->setDescription($refund->getDescription());

            $amountValueToRefund -= ((float)$amountToRefund->getAmountValue());
            $index++;

            $this->getProxy()->createPaymentRefund($paymentForRefund, $existingPayment->getId());
        }
    }

    /**
     * Check if refund all remaining items
     *
     * @param Order $existingOrder
     * @param OrderLine[] $refundLinesMap
     *
     * @return bool
     * @throws RefundNotAllowedException
     */
    private function allItemsRefunding(Order $existingOrder, array $refundLinesMap)
    {
        $allItemsRefunded = true;
        foreach ($existingOrder->getLines() as $existingLine) {
            if ($existingLine->getType() === 'discount') {
                continue;
            }

            if (array_key_exists($existingLine->getId(), $refundLinesMap)) {
                $this->recalculateRefundableQuantity($refundLinesMap[$existingLine->getId()], $existingLine);
            }

            if ($existingLine->getRefundableQuantity() > 0) {
                return false;
            }
        }

        return $allItemsRefunded;
    }

    /**
     * @param OrderLine $refundLine
     * @param OrderLine $existingLine
     *
     * @throws RefundNotAllowedException
     */
    private function recalculateRefundableQuantity(OrderLine $refundLine, OrderLine $existingLine)
    {
        $recalculatedQty = $existingLine->getRefundableQuantity() - $refundLine->getQuantity();
        if ($recalculatedQty < 0) {
            throw new RefundNotAllowedException('Refund item quantity is bigger than ordered');
        }

        $existingLine->setRefundableQuantity($recalculatedQty);
    }

    /**
     * Returns amount to refund. If amount value
     *
     * @param $amountValueToRefund
     * @param Amount $existingAmount
     *
     * @return Amount
     */
    private function getAmountForRefund($amountValueToRefund, Amount $existingAmount)
    {
        $amount = new Amount();
        $amount->setCurrency($existingAmount->getCurrency());
        $amount->setAmountValue(min($amountValueToRefund, $existingAmount->getAmountValue()));

        return $amount;
    }

    /**
     * Returns OrderReference entity by shop order id
     *
     * @param $shopReference
     *
     * @return OrderReference|null
     */
    private function getOrderReference($shopReference)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);

        return $orderReferenceService->getByShopReference($shopReference);
    }

    /**
     * Returns payments that can be refunded
     *
     * @param Order $order
     *
     * @return array
     * @throws RefundNotAllowedException
     */
    private function getRefundablePayments(Order $order)
    {
        $embedded = $order->getEmbedded();
        $payments = $embedded['payments'];
        $refundablePayments = array();
        /** @var Payment $payment */
        foreach ($payments as $payment) {
            if (in_array($payment->getStatus(), array('authorized', 'paid'))) {
                $refundablePayments[] = $payment;
            }
        }

        if (empty($refundablePayments)) {
            throw new RefundNotAllowedException('There are no refundable payments');
        }

        return $refundablePayments;
    }

    /**
     * Check if amount to refund is bigger than the refundable amount
     *
     * @param float $amountToRefund
     * @param Order $order
     *
     * @throws RefundNotAllowedException
     */
    private function checkIfRefundIsPossible($amountToRefund, Order $order)
    {
        $refundableAmount = $order->getAmount()->getAmountValue() - $order->getAmountRefunded()->getAmountValue();
        if ($amountToRefund > $refundableAmount) {
            throw new RefundNotAllowedException('Amount to refund is bigger than the refundable amount');
        }
    }
}
