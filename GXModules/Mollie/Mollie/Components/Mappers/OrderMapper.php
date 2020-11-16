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
     * @var \ProductReadServiceInterface
     */
    private $productReadService;


    /**
     * OrderMapper constructor.
     */
    public function __construct()
    {
        $this->orderReadService = \StaticGXCoreLoader::getService('OrderRead');
        $this->productReadService = \StaticGXCoreLoader::getService('ProductRead');
    }

    /**
     * @param int $orderId
     *
     * @return Order
     */
    public function getOrder($orderId)
    {
        /** @var \OrderInterface $sourceOrder */
        $sourceOrder = $this->orderReadService->getOrderById(new \IdType($orderId));
        $orderTotals = $sourceOrder->getOrderTotals();
        $currency = $sourceOrder->getCurrencyCode()->getCode();

        $orderMollie = new Order();
        $orderMollie->setOrderNumber((string)$orderId);
        $orderMollie->setLocale($this->_getLanguage());
        $orderMollie->setMethod([$this->_formatPaymentMethod($sourceOrder->getPaymentType()->getModule())]);
        $orderMollie->setRedirectUrl($this->_getRedirectUrl($orderId));
        $email = $sourceOrder->getCustomerEmail();
        $phone =$sourceOrder->getCustomerTelephone();
        $orderMollie->setBillingAddress($this->getAddressData($sourceOrder->getBillingAddress(), $email, $phone));
        $orderMollie->setShippingAddress($this->getAddressData($sourceOrder->getDeliveryAddress(), $email, $phone));
        $orderMollie->setWebhookUrl($this->_getConfigService()->getWebhookUrl());

        $lines = $this->getOrderLines($sourceOrder->getOrderItems(), $currency);
        $orderMollie->setAmount($this->_getAmount($currency, $this->getOrderTotalAmount($orderTotals, $sourceOrder->getOrderItems())));

        $orderTotalMapper = new OrderTotalMapper($currency);
        $lines = array_merge($lines, $orderTotalMapper->getOrderTotals($sourceOrder->getOrderTotals()));

        $orderMollie->setLines($lines);

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
            $mollieOrderLine->setUnitPrice($this->_getAmount($currency, $item->getPrice()));
            if ($item->getDiscountMade()) {
                $mollieOrderLine->setDiscountAmount($this->_getAmount($currency, $item->getDiscountMade()));
            }

            $mollieOrderLine->setTotalAmount($this->_getAmount($currency, $item->getFinalPrice()));

            $tax = $item->getTax();
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
        $sourceOrder = $this->orderReadService->getOrderById(new \IdType($orderId));
        $currency = $sourceOrder->getCurrencyCode()->getCode();

        $payment = new Payment();

        $amount  = $this->_getAmount($currency, $this->getOrderTotalAmount($sourceOrder->getOrderTotals(), $sourceOrder->getOrderItems()));
        $payment->setAmount($amount);
        $payment->setDescription("Order #$orderId");
        $payment->setOrderId((string)$orderId);
        $payment->setRedirectUrl($this->_getRedirectUrl($orderId));
        $payment->setLocale($this->_getLanguage());
        $payment->setMethod([$this->_formatPaymentMethod($sourceOrder->getPaymentType()->getModule())]);
        $email = $sourceOrder->getCustomerEmail();
        $phone = $sourceOrder->getCustomerTelephone();
        $payment->setShippingAddress($this->getAddressData($sourceOrder->getDeliveryAddress(), $email, $phone));
        $payment->setWebhookUrl($this->_getConfigService()->getWebhookUrl());

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

}
