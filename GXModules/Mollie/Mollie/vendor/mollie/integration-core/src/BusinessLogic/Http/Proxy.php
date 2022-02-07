<?php

namespace Mollie\BusinessLogic\Http;

use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\Customer;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Orders\Shipment;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Http\DTO\PaymentMethod;
use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Http\DTO\TokenPermission;
use Mollie\BusinessLogic\Http\DTO\WebsiteProfile;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\Logger\LogData;

/**
 * Class Proxy. In charge for communication with Mollie API.
 *
 * @package Mollie\BusinessLogic\Http
 */
class Proxy extends BaseProxy
{

    /**
     * @param LogData $data
     */
    public function createLog(LogData $data)
    {
        // TODO: Implement this when API endpoint is available
    }

    /**
     * Cancel order through Orders API
     *
     * @param string $orderId
     *
     * @return Order
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function cancelOrder($orderId)
    {
        $response = $this->call(self::HTTP_METHOD_DELETE, "/orders/{$orderId}");
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Order::fromArray($result) : new Order();
    }

    /**
     * @param string $orderId Mollie order identifier
     * @param string $orderLineId Mollie order line identifier
     * @param OrderLine $updatedOrderLine dto for update
     *
     * @return Order
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function updateOrderLine($orderId, $orderLineId, OrderLine $updatedOrderLine)
    {
        $requestBody = $this->transformer->transformOrderLinesForUpdate($updatedOrderLine);
        $result = $this->call(self::HTTP_METHOD_PATCH, "/orders/{$orderId}/lines/$orderLineId", $requestBody);

        return is_array($result) ? Order::fromArray($result) : new Order();
    }

    /**
     * @param string $orderId
     * @param Order $order
     *
     * @return Order
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function updateOrder($orderId, Order $order)
    {
        $requestBody = $this->transformer->transformOrderForUpdate($order);
        $response = $this->call(self::HTTP_METHOD_PATCH, "/orders/$orderId", $requestBody);
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Order::fromArray($result) : new Order();
    }

    /**
     * Cancel payment through Payments API
     *
     * @param string $paymentId
     *
     * @return Payment
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function cancelPayment($paymentId)
    {
        $response = $this->call(self::HTTP_METHOD_DELETE, "/payments/{$paymentId}");
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Payment::fromArray($result) : new Payment();
    }

    /**
     * @param Refund $refund data for payment refund
     * @param string $paymentId payment identifier
     *
     * @return Refund
     *
     * @throws HttpAuthenticationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     * @throws HttpCommunicationException
     */
    public function createPaymentRefund(Refund $refund, $paymentId)
    {
        $refundData = $this->transformer->transformPaymentRefund($refund);
        $response = $this->call(static::HTTP_METHOD_POST, "/payments/{$paymentId}/refunds", $refundData);
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Refund::fromArray($result) : new Refund();
    }

    /**
     * @param Refund $refund
     * @param string $orderId
     *
     * @return Refund
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function createOrderLinesRefund(Refund $refund, $orderId)
    {
        $refundData = $this->transformer->transformOrderLinesRefund($refund);
        $response = $this->call(self::HTTP_METHOD_POST, "orders/{$orderId}/refunds", $refundData);
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Refund::fromArray($result) : new Refund();
    }

    /**
     * Gets current token permission list
     *
     * @return TokenPermission[]
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getAccessTokenPermissions()
    {
        $response = $this->call(self::HTTP_METHOD_GET, '/permissions');
        $result = $response->decodeBodyAsJson();

        if (empty($result['_embedded']['permissions'])) {
            return array();
        }

        return TokenPermission::fromArrayBatch($result['_embedded']['permissions']);
    }

    /**
     * Return current mollie profile
     *
     * @return DTO\BaseDto|WebsiteProfile
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getCurrentProfile()
    {
        $response = $this->call(self::HTTP_METHOD_GET, '/profiles/me');
        $result = $response->decodeBodyAsJson();

        return WebsiteProfile::fromArray($result);
    }

    /**
     * Gets list of website profiles from Mollie API
     *
     * @return WebsiteProfile[]
     *
     * @throws HttpAuthenticationException
     * @throws UnprocessableEntityRequestException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getWebsiteProfiles()
    {
        $response = $this->call(self::HTTP_METHOD_GET, '/profiles?limit=250');
        $result = $response->decodeBodyAsJson();

        return WebsiteProfile::fromArrayBatch(
            !empty($result['_embedded']['profiles']) ? $result['_embedded']['profiles'] : array()
        );
    }

    /**
     * Gets all payment methods that Mollie API offers and can be activated by the Organization
     *
     * @return PaymentMethod[]
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getAllPaymentMethods()
    {
        $params = array(
            'include' => 'issuers',
        );
        $queryString = http_build_query($params);
        $response = $this->call(self::HTTP_METHOD_GET, "/methods/all?{$queryString}");
        $result = $response->decodeBodyAsJson();

        return PaymentMethod::fromArrayBatch(
            !empty($result['_embedded']['methods']) ? $result['_embedded']['methods'] : array()
        );
    }

    /**
     * Gets all enabled payment methods from Mollie API in form of a dictionary, where dictionary key is payment method id and
     * value is payment method DTO
     *
     * @param string|null $billingCountry The billing country of your customer in ISO 3166-1 alpha-2 format.
     * @param Amount|null $amount
     * @param string $apiMethod Api method to use for availability checking. Default is orders api
     * @param array $orderLineCategories
     *
     * @return PaymentMethod[]
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabledPaymentMethodsMap(
        $billingCountry = null,
        $amount = null,
        $apiMethod = PaymentMethodConfig::API_METHOD_ORDERS,
        $orderLineCategories = array()
    )
    {
        $paymentMethodsMap = array();
        $paymentMethods = $this->getEnabledPaymentMethods($billingCountry, $amount, $apiMethod, $orderLineCategories);
        foreach ($paymentMethods as $paymentMethod) {
            $paymentMethodsMap[$paymentMethod->getId()] = $paymentMethod;
        }

        return $paymentMethodsMap;
    }

    /**
     * Gets all enabled payment methods from Mollie API
     *
     * @param string|null $billingCountry The billing country of your customer in ISO 3166-1 alpha-2 format.
     * @param Amount|null $amount
     * @param string $apiMethod Api method to use for availability checking. Default is orders api
     * @param array $orderLineCategories
     *
     * @return PaymentMethod[]
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabledPaymentMethods(
        $billingCountry = null,
        $amount = null,
        $apiMethod = PaymentMethodConfig::API_METHOD_ORDERS,
        $orderLineCategories = array()
    )
    {
        $queryString = $this->buildQueryParamsForEnabledMethod($apiMethod, $billingCountry, $amount, $orderLineCategories);

        $response = $this->call(self::HTTP_METHOD_GET, "/methods?{$queryString}");
        $result = $response->decodeBodyAsJson();

        return PaymentMethod::fromArrayBatch(
            !empty($result['_embedded']['methods']) ? $result['_embedded']['methods'] : array()
        );
    }

    /**
     * @param string $apiMethod
     * @param string $billingCountry
     * @param Amount $amount
     * @param array $orderLineCategories
     *
     * @return string
     */
    protected function buildQueryParamsForEnabledMethod($apiMethod, $billingCountry, $amount, $orderLineCategories)
    {
        $params = array(
            'include' => 'issuers',
            'includeWallets' => 'applepay',
            'resource' => $apiMethod === PaymentMethodConfig::API_METHOD_PAYMENT ? 'payments' : 'orders',
        );

        if (!empty($billingCountry)) {
            $params['billingCountry'] = $billingCountry;
        }

        if ($amount) {
            $params['amount'] = $amount->toArray();
        }

        if (!empty($orderLineCategories)) {
            $params['orderLineCategories'] = implode(',', $orderLineCategories);
        }

        return http_build_query($params);
    }

    /**
     * Returns enabled methods for the given profile ID
     *
     * @param string $profileId
     *
     * @return PaymentMethod[]
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabledPaymentMethodsForProfile($profileId)
    {
        $queryParams = array(
            'profileId' => $profileId,
            'include' => 'issuers',
            'includeWallets' => 'applepay',
            'resource' => 'orders',
        );

        if ($this->configService->isTestMode()) {
            $queryParams['testmode'] = 'true';
        }

        $url = static::BASE_URL . static::API_VERSION . 'methods?' . http_build_query($queryParams);
        $response = $this->client->request(
            self::HTTP_METHOD_GET,
            $url,
            $this->getRequestHeaders()
        );

        $this->validateResponse($response);

        $result = $response->decodeBodyAsJson();

        return PaymentMethod::fromArrayBatch(
            !empty($result['_embedded']['methods']) ? $result['_embedded']['methods'] : array()
        );
    }

    /**
     * Creates new payment on Mollie
     *
     * @param Payment $payment Data for a new payment
     *
     * @return Payment Created payment
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function createPayment(Payment $payment)
    {
        $paymentData = $this->transformer->transformPayment($payment);
        $response = $this->call(self::HTTP_METHOD_POST, '/payments', $paymentData);
        $result = $response->decodeBodyAsJson();

        return Payment::fromArray($result);
    }

    /**
     * Gets payment by its id
     *
     * @param string $paymentId Mollie payment id
     *
     * @return Payment
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getPayment($paymentId)
    {
        $response = $this->call(self::HTTP_METHOD_GET, "/payments/{$paymentId}?embed=refunds");
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Payment::fromArray($result) : new Payment();
    }

    /**
     * Creates new order on Mollie
     *
     * @param Order $order Data for a new order
     *
     * @return Order Created order
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function createOrder(Order $order)
    {
        $orderData = $this->transformer->transformOrder($order);
        $response = $this->call(self::HTTP_METHOD_POST, '/orders', $orderData);
        $result = $response->decodeBodyAsJson();

        return !empty($result['id']) ? $this->getOrder($result['id']) : Order::fromArray($result);
    }

    /**
     * Returns order by its id
     *
     * @param string $orderId Mollie order id
     *
     * @return Order
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getOrder($orderId)
    {
        $response = $this->call(self::HTTP_METHOD_GET, "orders/{$orderId}?embed=payments,refunds");
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Order::fromArray($result) : new Order();
    }

    /**
     * Creates customer on customers API
     *
     * @param Customer $customer
     *
     * @return Customer
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function createCustomer(Customer $customer)
    {
        $customerData = $this->transformer->transformCustomer($customer);
        $response = $this->call(
            self::HTTP_METHOD_POST,
            'customers',
            $customerData
        );
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Customer::fromArray($result) : new Customer();
    }

    /**
     * Removes customer from Mollie by its id
     *
     * @param string $id customer identifier on Mollie
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function deleteCustomer($id)
    {
        $this->call(self::HTTP_METHOD_DELETE, "customers/$id");
    }

    /**
     * Creates order shipment on Mollie
     *
     * @param Shipment $shipment
     *
     * @return Shipment Created shipment
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function createShipment(Shipment $shipment)
    {
        $shipmentData = $this->transformer->transformShipment($shipment);
        $response = $this->call(
            self::HTTP_METHOD_POST,
            "/orders/{$shipment->getOrderId()}/shipments",
            $shipmentData
        );
        $result = $response->decodeBodyAsJson();

        return is_array($result) ? Shipment::fromArray($result) : new Shipment();
    }

    /**
     * Returns all shipments for given order id
     *
     * @param string $orderId
     *
     * @return array|Shipment[]
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getShipments($orderId)
    {
        $endpoint = "/orders/$orderId/shipments";
        $response = $this->call(self::HTTP_METHOD_GET, $endpoint);
        $result = $response->decodeBodyAsJson();
        if (empty($result['_embedded']['shipments'])) {
            return array();
        }

        return Shipment::fromArrayBatch($result['_embedded']['shipments']);
    }
}
