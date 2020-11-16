<?php

namespace Mollie\BusinessLogic\Orders;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\Http\DTO\Address;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class OrderService
 *
 * @package Mollie\BusinessLogic\Orders
 */
class OrderService extends BaseService
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
     * Creates new order on Mollie for a provided order data
     *
     * @param string $shopReference Unique identifier of a shop order
     * @param Order $order Order data to pass to create method
     *
     * @return Order Created order instance
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function createOrder($shopReference, Order $order)
    {
        $createdOrder = $this->getProxy()->createOrder($order);
        $this->updateOrderReference($shopReference, $createdOrder);

        return $createdOrder;
    }

    /**
     * @param $shopReference
     *
     * @return Order
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     */
    public function getOrder($shopReference)
    {
        return $this->getProxy()->getOrder(
            $this->getValidOrderReference($shopReference)->getMollieReference()
        );
    }

    /**
     * @param string|int $shopReference
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     * @throws UnprocessableEntityRequestException
     */
    public function getShipments($shopReference)
    {
        $orderReference = $this->getValidOrderReference($shopReference);

        $this->getProxy()->getShipments($orderReference->getMollieReference());
    }

    /**
     * @param string $shopReference order id from shop
     * @param OrderLine $orderLine DTO for update
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     * @throws UnprocessableEntityRequestException
     */
    public function updateOrderLine($shopReference, OrderLine $orderLine)
    {
        $orderReference = $this->getValidOrderReference($shopReference);
        $this->getProxy()->updateOrderLine($orderReference->getMollieReference(), $orderLine->getId(), $orderLine);
    }

    /**
     * Updates billing address
     *
     * @param string $shopReference
     * @param Address $billingAddress
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     * @throws UnprocessableEntityRequestException
     */
    public function updateBillingAddress($shopReference, Address $billingAddress)
    {
        $orderDto = new Order();
        $orderDto->setBillingAddress($billingAddress);

        $this->updateOrderAddress($shopReference, $orderDto);
    }

    /**
     * Updates shipping address
     *
     * @param string $shopReference
     * @param Address $shippingAddress
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     * @throws UnprocessableEntityRequestException
     */
    public function updateShippingAddress($shopReference, Address $shippingAddress)
    {
        $orderDto = new Order();
        $orderDto->setShippingAddress($shippingAddress);

        $this->updateOrderAddress($shopReference, $orderDto);
    }

    /**
     * @param string $shopReference
     * @param Order $orderDto
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws ReferenceNotFoundException
     * @throws UnprocessableEntityRequestException
     */
    protected function updateOrderAddress($shopReference, Order $orderDto)
    {
        $orderReference = $this->getValidOrderReference($shopReference);
        $this->getProxy()->updateOrder($orderReference->getMollieReference(), $orderDto);
    }

    /**
     * Gets order reference with existing Mollie reference
     *
     * @param string $shopReference
     *
     * @return OrderReference
     *
     * @throws ReferenceNotFoundException
     */
    protected function getValidOrderReference($shopReference)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);

        return $orderReferenceService->getValidOrderReference($shopReference, PaymentMethodConfig::API_METHOD_ORDERS);
    }

    /**
     * @param $shopReference
     * @param Order $order
     */
    protected function updateOrderReference($shopReference, Order $order)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        $orderReferenceService->updateOrderReference(
            $order,
            $shopReference,
            PaymentMethodConfig::API_METHOD_ORDERS
        );
    }
}
