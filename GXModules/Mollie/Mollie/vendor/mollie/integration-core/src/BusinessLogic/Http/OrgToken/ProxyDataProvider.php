<?php

namespace Mollie\BusinessLogic\Http\OrgToken;

use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\Http\DTO\Address;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Orders\Shipment;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethods;
use Mollie\Infrastructure\Exceptions\InvalidConfigurationException;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class ProxyDataProvider
 *
 * @package Mollie\BusinessLogic\Http
 */
class ProxyDataProvider
{
    const CLASS_NAME = __CLASS__;

    /**
     * Regular expression for simple phone validation (must contain + at the beginning and all digits)
     */
    const PHONE_REGEX = "/^\+\d+$/";

    protected static $profileIdRequiredEndpoints = array (
        'methods'
    );

    /**
     * @var Configuration
     */
    protected $configService;

    public function transformPayment(Payment $payment)
    {
        $method = $payment->getMethod();
        if (count($method) === 1) {
            $method = implode('', $method);
        }

        $result = array(
            'profileId' => $payment->getProfileId(),
            'description' => $payment->getDescription(),
            'amount' => $payment->getAmount()->toArray(),
            'redirectUrl' => $payment->getRedirectUrl(),
            'webhookUrl' => $payment->getWebhookUrl(),
            'locale' => $payment->getLocale(),
            'method' => $method,
            'metadata' => $payment->getMetadata(),
        );

        $shippingAddress = $payment->getShippingAddress();
        if ($shippingAddress && $method === PaymentMethods::PayPal) {
            $result['shippingAddress'] = array(
                'streetAndNumber' => $shippingAddress->getStreetAndNumber(),
                'streetAdditional' => $shippingAddress->getStreetAdditional(),
                'city' => $shippingAddress->getCity(),
                'region' => $shippingAddress->getRegion(),
                'postalCode' => $shippingAddress->getPostalCode(),
                'country' => $shippingAddress->getCountry(),
            );
        }

        $result = array_merge($result, $this->getCommonPaymentParameters($payment));

        return $result;
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function transformOrder(Order $order)
    {
        $orderLines = $order->getLines();
        $totalAdjustment = $this->getOrderAdjustment($order);
        if ($totalAdjustment) {
            $orderLines[] = $totalAdjustment;
        }

        $method = $order->getMethod();
        if (count($method) === 1) {
            $method = implode('', $method);
        }

        $orderData = array(
            'profileId' => $order->getProfileId(),
            'amount' => $order->getAmount()->toArray(),
            'orderNumber' => $order->getOrderNumber(),
            'billingAddress' => $this->transformAddress($order->getBillingAddress()),
            'redirectUrl' => $order->getRedirectUrl(),
            'webhookUrl' => $order->getWebhookUrl(),

            'locale' => $order->getLocale(),
            'method' => $method,
            'metadata' => $order->getMetadata(),
            'lines' => $this->transformOrderLines($orderLines),
        );

        if ($expiresAt = $order->getExpiresAt()) {
            $orderData['expiresAt'] = $expiresAt->format(Order::MOLLIE_DATE_FORMAT);
        }

        if ($shippingAddress = $order->getShippingAddress()) {
            $orderData['shippingAddress'] = $this->transformAddress($shippingAddress);
        }

        if ($consumerDateOfBirth = $order->getConsumerDateOfBirth()) {
            $orderData['consumerDateOfBirth'] = $consumerDateOfBirth->format(Order::MOLLIE_DATE_FORMAT);
        }

        if ($order->getPayment()) {
            $orderData['payment'] = $this->getCommonPaymentParameters($order->getPayment());
        }

        // ensure that webhookUrl is same as on the order object
        $orderData['payment']['webhookUrl'] = $order->getWebhookUrl();

        return $orderData;
    }

    /**
     *
     * @param Order $order
     *
     * @return array
     */
    public function transformOrderForUpdate(Order $order)
    {
        $result = array();
        if ($order->getBillingAddress() !== null) {
            $result['billingAddress'] = $this->transformAddress($order->getBillingAddress());
        }

        if ($order->getShippingAddress() !== null) {
            $result['shippingAddress'] = $this->transformAddress($order->getShippingAddress());
        }

        return $result;
    }

    /**
     * @param OrderLine[] $orderLines
     *
     * @return array Order lines data as an array
     */
    public function transformOrderLines(array $orderLines)
    {
        $result = array();
        foreach ($orderLines as $orderLine) {
            $orderLineData = array(
                'name' => $orderLine->getName(),
                'quantity' => $orderLine->getQuantity(),
                'unitPrice' => $orderLine->getUnitPrice()->toArray(),
                'totalAmount' => $orderLine->getTotalAmount()->toArray(),
                'vatRate' => $orderLine->getVatRate(),
                'vatAmount' => $orderLine->getVatAmount()->toArray(),
                'sku' => $orderLine->getSku(),
                'metadata' => $orderLine->getMetadata(),
            );

            $type = $orderLine->getType();
            if (!empty($type)) {
                $orderLineData['type'] = $type;
            }

            $category = $orderLine->getCategory();
            if (!empty($category)) {
                $orderLineData['category'] = $category;
            }

            if ($discountAmount = $orderLine->getDiscountAmount()) {
                $orderLineData['discountAmount'] = $discountAmount->toArray();
            }

            $result[] = $orderLineData;
        }

        return $result;
    }

    /**
     * Transform order lines for cancellation
     *
     * @param OrderLine $orderLine
     *
     * @return array
     */
    public function transformOrderLinesForUpdate(OrderLine $orderLine)
    {
        $result = array();
        if ($orderLine->getName() !== null) {
            $result['name'] = $orderLine->getName();
        }

        if ($orderLine->getQuantity() !== null) {
            $result['quantity'] = $orderLine->getQuantity();
        }

        if ($orderLine->getUnitPrice() !== null) {
            $result['unitPrice'] = $orderLine->getUnitPrice()->toArray();
        }

        if ($orderLine->getDiscountAmount() !== null) {
            $result['discountAmount'] = $orderLine->getDiscountAmount()->toArray();
        }

        if ($orderLine->getTotalAmount() !== null) {
            $result['totalAmount'] = $orderLine->getTotalAmount()->toArray();
        }

        if ($orderLine->getVatAmount() !== null) {
            $result['vatAmount'] = $orderLine->getVatAmount()->toArray();
        }

        if ($orderLine->getVatRate() !== null) {
            $result['vatRate'] = $orderLine->getVatRate();
        }

        return $result;
    }

    /**
     * Transforms Refund DTO to payload body for create refund on the payments API
     *
     * @param Refund $refund DTO
     *
     * @return array
     */
    public function transformPaymentRefund(Refund $refund)
    {
        return array(
            'amount' => $refund->getAmount()->toArray(),
            'description' => $refund->getDescription(),
            'metadata' => $refund->getMetadata(),
        );
    }

    /**
     * Transforms Refund DTO to payload body for create refund on the orders API
     *
     * @param Refund $refund
     *
     * @return array
     */
    public function transformOrderLinesRefund(Refund $refund)
    {
        $refundLines = array();
        foreach ($refund->getLines() as $orderLine) {
            $quantity = $orderLine->getQuantity();
            if ($quantity < 1) {
                continue;
            }

            $refundLine = array();
            $refundLine['id'] = $orderLine->getId();
            $refundLine['quantity'] = $quantity;

            $refundLines[] = $refundLine;
        }

        return array(
            'lines' => $refundLines,
            'metadata' => $refund->getMetadata(),
        );
    }

    public function transformAddress(Address $address)
    {
        $addressData = $address->toArray();

        // Remove all common phone number delimiters and make sure phone has + at the beginning and no 0
        $addressData['phone'] = str_replace(array('+', ' ', '-', '/'), '', $addressData['phone']);
        $addressData['phone'] = ltrim($addressData['phone'], '0');
        $addressData['phone'] = '+' . $addressData['phone'];
        if (!preg_match(static::PHONE_REGEX, $addressData['phone'])) {
            unset($addressData['phone']);
        }

        return $addressData;
    }

    /**
     * Calculates additional discount or surcharge based on total amounts set on order lines and total amount set o order
     *
     * @param Order $order
     *
     * @return OrderLine|null
     */
    protected function getOrderAdjustment(Order $order)
    {
        $lineItemsTotal = array_reduce($order->getLines(), function ($carry, OrderLine $line) {
            $carry += (float)$line->getTotalAmount()->getAmountValue();
            return $carry;
        }, 0);

        $orderTotal = (float)$order->getAmount()->getAmountValue();
        $totalDiff = $orderTotal - $lineItemsTotal;
        if (abs($totalDiff) >= 0.001) {
            return OrderLine::fromArray(array(
                'name' => 'Adjustment',
                'type' => ($totalDiff > 0) ? 'surcharge' : 'discount',
                'quantity' => 1,
                'unitPrice' => array(
                    'value' => (string)$totalDiff,
                    'currency' => $order->getAmount()->getCurrency()
                ),
                'totalAmount' => array(
                    'value' => (string)$totalDiff,
                    'currency' => $order->getAmount()->getCurrency()
                ),
                'vatRate' => '0.00',
                'vatAmount' => array(
                    'value' => '0.00',
                    'currency' => $order->getAmount()->getCurrency()
                ),
            ));
        }

        return null;
    }

    /**
     * @param Shipment $shipment
     *
     * @return array[]
     */
    public function transformShipment(Shipment $shipment)
    {
        $lines = array();
        foreach ($shipment->getLines() as $line) {
            $lineData = array('id' => $line->getId());
            if ($line->getQuantity() > 0) {
                $lineData['quantity'] = $line->getQuantity();
            }

            $lines[] = $lineData;
        }

        $result = array('lines' => $lines);
        if ($shipment->getTracking()) {
            $result['tracking'] = $shipment->getTracking()->toArray();
        }

        return $result;
    }

    /**
     * @param string $url
     * @param string $endpoint
     * @param string $method
     *
     * @throws InvalidConfigurationException
     */
    public function adjustUrl(&$url, $endpoint, $method)
    {
        if (strtoupper($method) === Proxy::HTTP_METHOD_GET) {
            if ($this->attachTestModeParameter($endpoint)) {
                $this->addQueryParameters($url, array('testmode' => 'true'));
            }

            if ($this->isProfileIdRequired($endpoint)) {
                $profile = $this->getConfigService()->getWebsiteProfile();
                if (!$profile) {
                    throw new InvalidConfigurationException('Profile not found in configuration!');
                }

                $this->addQueryParameters($url, array('profileId' => $profile->getId()));
            }
        }
    }

    /**
     *
     * @param array $body
     * @param string $endpoint
     */
    public function adjustBody(array &$body, $endpoint)
    {
        if ($this->attachTestModeParameter($endpoint)) {
            $body['testmode'] = true;
        }
    }

    /**
     * Return payment parameters that could be sent on both API-s
     * @param Payment $payment
     *
     * @return array
     */
    protected function getCommonPaymentParameters(Payment $payment)
    {
        $paymentSpecific = array();
        if ($payment->getIssuer()) {
            $paymentSpecific['issuer'] = $payment->getIssuer();
        }

        if ($payment->getCardToken()) {
            $paymentSpecific['cardToken'] = $payment->getCardToken();
        }

        if ($payment->getWebhookUrl()) {
            $paymentSpecific['webhookUrl'] = $payment->getWebhookUrl();
        }

        if ($payment->getDueDate()) {
            $paymentSpecific['dueDate'] = $payment->getDueDate()->format(Order::MOLLIE_DATE_FORMAT);
        }

        return $paymentSpecific;
    }

    /**
     * Checks if test mode is enabled for a provided endpoint
     *
     * @param string $endpoint Endpoint resource on remote API.
     *
     * @return bool True if test mode is on; false otherwise
     */
    protected function attachTestModeParameter($endpoint)
    {
        $unsupportedTestModeEndpoints = array('permissions', 'profiles/me');
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        // Test mode is on if it is configured and requesting endpoint supports test mode
        return $configService->isTestMode() && !in_array($endpoint, $unsupportedTestModeEndpoints, true);
    }

    /**
     * @param string $endpoint
     *
     * @return bool
     */
    protected function isProfileIdRequired($endpoint)
    {
        foreach (static::$profileIdRequiredEndpoints as $requiredEndpoint) {
            if (strpos($endpoint, $requiredEndpoint) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $url
     * @param array $queryParams
     */
    protected function addQueryParameters(&$url, array $queryParams)
    {
        $url .= false === strpos($url, '?') ? '?' : '&';
        $url .= http_build_query($queryParams);
    }

    /**
     * @return Configuration
     */
    protected function getConfigService()
    {
        if ($this->configService === null) {
            $this->configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        }

        return $this->configService;
    }
}
