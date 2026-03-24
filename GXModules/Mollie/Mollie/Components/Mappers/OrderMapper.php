<?php


namespace Mollie\Gambio\Mappers;


use Mollie\BusinessLogic\Http\DTO\Address;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Payment;

/**
 * Class OrderMapper
 *
 * @package Mollie\Gambio\Mappers
 */
class OrderMapper
{
    const PHONE_REGEX = "/^\+?[1-9]\d{1,14}$/";

    use MapperUtility;

    /**
     * @var \OrderReadServiceInterface
     */
    private $orderReadService;

    /**
     * @param int $orderId
     *
     * @return Order
     */
    public function getOrder($orderId)
    {
        /** @var \OrderInterface $sourceOrder */
        $sourceOrder = $this->getOrderReadService()->getOrderById(new \IdType($orderId));
        $orderTotals = $sourceOrder->getOrderTotals();
        $currency = $sourceOrder->getCurrencyCode()->getCode();

        $orderMollie = new Order();
        $orderMollie->setOrderNumber((string)$orderId);
        $orderMollie->setLocale($this->_getLanguage());
        $orderMollie->setMethods([$this->_formatPaymentMethod($sourceOrder->getPaymentType()->getModule())]);
        $orderMollie->setRedirectUrl($this->_getRedirectUrl($orderId));
        $email = $sourceOrder->getCustomerEmail();
        $phone =$sourceOrder->getCustomerTelephone();
        $orderMollie->setBillingAddress($this->getAddressData($sourceOrder->getBillingAddress(), $email, $phone));
        $orderMollie->setShippingAddress($this->getAddressData($sourceOrder->getDeliveryAddress(), $email, $phone));
        $orderMollie->setWebhookUrl($this->_getConfigService()->getWebhookUrl());

        $taxAllowed = $this->isTaxAllowedForOrder($sourceOrder->getOrderItems());
        $lines = $this->getOrderLines($sourceOrder->getOrderItems(), $currency);

        $orderTotalMapper = new OrderTotalMapper($currency);
        $lines = array_merge($lines, $orderTotalMapper->getOrderTotals($sourceOrder->getOrderTotals()));

        if (!$taxAllowed) {
            $grossTotal = $this->getGrossTotal($lines, $orderTotals, $currency);
            $orderMollie->setAmount($this->_getAmount($currency, $grossTotal));
        } else {
            $orderMollie->setAmount($this->_getAmount($currency, $this->getOrderTotalAmount($orderTotals, $sourceOrder->getOrderItems())));
        }

        $orderMollie->setLines($lines);

        $orderMollie->setPayment($this->getCommonPaymentData());
        $daysToExpire = $this->getDaysToExpireOrder($sourceOrder->getPaymentType()->getPaymentClass());
        if (!empty($daysToExpire)) {
            $orderMollie->calculateExpiresAt((int)$daysToExpire);
        }

        return $orderMollie;
    }

    public function getOrderLines(\OrderItemCollection $itemCollection, $currency)
    {
        $lines = [];
        /** @var \StoredOrderItemInterface $item */
        foreach ($itemCollection as $item) {
            $mollieOrderLine = new OrderLine();

            $mollieOrderLine->setType('physical');
            $mollieOrderLine->setName($item->getName());
            $mollieOrderLine->setQuantity((int)$item->getQuantity());

            $unitPrice = $item->getPrice();
            $totalPrice = $item->getFinalPrice();
            $tax = $item->getTax();

            if (!$item->isTaxAllowed() && $tax > 0) {
                $unitPrice = round($unitPrice * (1 + $tax / 100), 2);
                $totalPrice = round($totalPrice * (1 + $tax / 100), 2);
            }

            $mollieOrderLine->setUnitPrice($this->_getAmount($currency, $unitPrice));
            if ($item->getDiscountMade()) {
                $mollieOrderLine->setDiscountAmount($this->_getAmount($currency, $item->getDiscountMade()));
            }

            $mollieOrderLine->setTotalAmount($this->_getAmount($currency, $totalPrice));

            $mollieOrderLine->setVatRate($tax);
            $vat = $mollieOrderLine->getTotalAmount()->getAmountValue() * ($tax / (100 + $tax));
            $mollieOrderLine->setVatAmount($this->_getAmount($currency, $vat));
            $mollieOrderLine->setSku($item->getProductModel());

            $mollieOrderLine->setMetadata(['order_line_id' => $item->getOrderItemId()]);

            $lines[] = $mollieOrderLine;
        }

        return $lines;
    }

    public function getPayment($orderId)
    {
        /** @var \OrderInterface $sourceOrder */
        $sourceOrder = $this->getOrderReadService()->getOrderById(new \IdType($orderId));
        $currency = $sourceOrder->getCurrencyCode()->getCode();

        $payment = $this->getCommonPaymentData();

        $taxAllowed = $this->isTaxAllowedForOrder($sourceOrder->getOrderItems());

        $payment->setDescription($this->_getPaymentTransactionDescription($sourceOrder));
        $payment->setOrderId((string)$orderId);
        $payment->setRedirectUrl($this->_getRedirectUrl($orderId));
        $payment->setLocale($this->_getLanguage());
        $payment->setMethods([$this->_formatPaymentMethod($sourceOrder->getPaymentType()->getModule())]);
        $email = $sourceOrder->getCustomerEmail();
        $phone = $sourceOrder->getCustomerTelephone();
        $payment->setShippingAddress($this->getAddressData($sourceOrder->getDeliveryAddress(), $email, $phone));
        $payment->setBillingAddress($this->getAddressData($sourceOrder->getBillingAddress(), $email, $phone));

        $lines = $this->getOrderLines($sourceOrder->getOrderItems(), $currency);
        $orderTotalMapper = new OrderTotalMapper($currency);
        $lines = array_merge($lines, $orderTotalMapper->getOrderTotals($sourceOrder->getOrderTotals()));

        if (!$taxAllowed) {
            $grossTotal = $this->getGrossTotal($lines, $sourceOrder->getOrderTotals(), $currency);
            $payment->setAmount($this->_getAmount($currency, $grossTotal));
        } else {
            $payment->setAmount($this->_getAmount($currency, $this->getOrderTotalAmount($sourceOrder->getOrderTotals(), $sourceOrder->getOrderItems())));
        }

        $payment->setLines($lines);

        $daysToExpire = $this->getDaysToExpirePayment($sourceOrder->getPaymentType()->getPaymentClass());
        if (!empty($daysToExpire)) {
            $payment->calculateDueDate((int)$daysToExpire);
        }

        return $payment;
    }

    /**
     * @param \AddressBlockInterface $addressBlock
     * @param  string                      $email
     * @param  string                      $phone
     *
     * @return Address
     */
    public function getAddressData(\AddressBlockInterface $addressBlock, $email, $phone)
    {
        $mollieAddress = new Address();

        $mollieAddress->setEmail($email);
        $mollieAddress->setOrganizationName((string)$addressBlock->getCompany());
        $mollieAddress->setGivenName((string)$addressBlock->getFirstname());
        $mollieAddress->setFamilyName((string)$addressBlock->getLastname());
        if (preg_match(static::PHONE_REGEX, $phone)) {
            $mollieAddress->setPhone($phone);
        }

        $streetAndNumber = (string)$addressBlock->getStreet();
        if ($addressBlock->getHouseNumber()) {
            $streetAndNumber .= ' ' . $addressBlock->getHouseNumber();
        }

        $mollieAddress->setStreetAndNumber($streetAndNumber);
        $mollieAddress->setStreetAdditional((string)$addressBlock->getAdditionalAddressInfo());
        $mollieAddress->setPostalCode((string)$addressBlock->getPostcode());
        $mollieAddress->setCity((string)$addressBlock->getCity());
        $mollieAddress->setRegion((string)$addressBlock->getStreet());
        $mollieAddress->setCountry((string)$addressBlock->getCountry()->getIso2());

        return $mollieAddress;
    }

    /**
     * Return payment data for orders and payment api
     *
     * @return Payment
     */
    private function getCommonPaymentData()
    {
        $payment = new Payment();
        $payment->setWebhookUrl($this->_getConfigService()->getWebhookUrl());

        $this->addSpecificParameters($payment);


        return $payment;
    }

    /**
     * @param \OrderTotalCollection $orderTotals
     * @param \OrderItemCollection $lines
     *
     * @return float|int
     */
    private function getOrderTotalAmount(\OrderTotalCollection $orderTotals, \OrderItemCollection $lines)
    {
        /** @var \OrderTotalInterface $orderTotal */
        foreach ($orderTotals as $orderTotal) {
            if ($orderTotal->getClass() === 'ot_total') {
                return $orderTotal->getValue();
            }
        }
        $totalPrice = 0;
        /** @var \StoredOrderItemInterface $line */
        foreach ($lines as $line) {
            $totalPrice += $line->getFinalPrice();
        }

        return $totalPrice;
    }

    /**
     * Checks if the order uses tax-inclusive (gross) prices.
     *
     * @param \OrderItemCollection $items
     *
     * @return bool
     */
    private function isTaxAllowedForOrder(\OrderItemCollection $items)
    {
        foreach ($items as $item) {
            return $item->isTaxAllowed();
        }

        return true;
    }

    /**
     * @param OrderLine[] $lines  Passed by reference — adjustment line may be appended
     * @param \OrderTotalCollection $orderTotals
     * @param string $currency
     *
     * @return float
     */
    private function getGrossTotal(array &$lines, \OrderTotalCollection $orderTotals, $currency)
    {
        $lineSum = $this->sumLineAmounts($lines);

        if (!$this->hasTaxEntries($orderTotals)) {
            return $lineSum;
        }

        $gambioGross = $this->getGambioGrossTotal($orderTotals);

        if (abs($lineSum - $gambioGross) < 0.01) {
            return $lineSum;
        }

        $diff = $gambioGross - $lineSum;
        $adjustment = new OrderLine();
        $adjustment->setType('surcharge');
        $adjustment->setName('Tax adjustment');
        $adjustment->setQuantity(1);
        $adjustment->setUnitPrice($this->_getAmount($currency, $diff));
        $adjustment->setTotalAmount($this->_getAmount($currency, $diff));
        $adjustment->setVatRate(0);
        $adjustment->setVatAmount($this->_getAmount($currency, 0));
        $lines[] = $adjustment;

        return $gambioGross;
    }

    /**
     * Checks if the order has ot_tax entries.
     *
     * @param \OrderTotalCollection $orderTotals
     *
     * @return bool
     */
    private function hasTaxEntries(\OrderTotalCollection $orderTotals)
    {
        foreach ($orderTotals as $orderTotal) {
            if ($orderTotal->getClass() === 'ot_tax') {
                return true;
            }
        }

        return false;
    }

    /**
     * Computes the GROSS total from Gambio's order total components.
     * Only used when ot_tax entries exist (add_tax_ot=1).
     *
     * @param \OrderTotalCollection $orderTotals
     *
     * @return float
     */
    private function getGambioGrossTotal(\OrderTotalCollection $orderTotals)
    {
        $total = 0;
        $skippedClasses = ['ot_total', 'ot_subtotal_no_tax', 'ot_total_netto'];

        foreach ($orderTotals as $orderTotal) {
            if (in_array($orderTotal->getClass(), $skippedClasses, true)) {
                continue;
            }

            $total += $orderTotal->getValue();
        }

        return $total;
    }

    /**
     * Computes the total amount from the sum of all line item totalAmounts.
     *
     * @param OrderLine[] $lines
     *
     * @return float
     */
    private function sumLineAmounts(array $lines)
    {
        $total = 0;
        foreach ($lines as $line) {
            $total += (float) $line->getTotalAmount()->getAmountValue();
        }

        return $total;
    }

    /**
     * Returns an instance of the order read service.
     *
     * @return \OrderReadServiceInterface
     */
    private function getOrderReadService()
    {
        if ($this->orderReadService === null) {
            $this->orderReadService = \StaticGXCoreLoader::getService('OrderRead');
        }

        return $this->orderReadService;
    }
}
