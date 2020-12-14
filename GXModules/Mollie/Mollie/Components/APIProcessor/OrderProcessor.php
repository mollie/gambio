<?php

namespace Mollie\Gambio\APIProcessor;

use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\Gambio\Mappers\OrderMapper;
use Mollie\Gambio\Services\Business\StatusUpdate;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class OrderProcessor
 *
 * @package Mollie\Gambio\APIProcessor
 */
class OrderProcessor implements Interfaces\Processor
{
    use StatusUpdate;

    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var OrderMapper
     */
    private $mapper;

    /**
     * PaymentProcessor constructor.
     *
     * @param OrderMapper $mapper
     */
    public function __construct(OrderMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     * @return Result
     */
    public function create($orderId)
    {
        try {
            $createdOrder = $this->_getOrderService()->createOrder(
                $orderId,
                $this->mapper->getOrder($orderId)
            );

            $this->updateStatus($orderId, 'mollie_created');

            $links = $createdOrder->getLinks();
            if (array_key_exists('checkout', $links)) {
                return new Result(true, $createdOrder->getLink('checkout')->getHref());
            }

            return new Result(true, $this->getLinkFromPayment($createdOrder));
        } catch (\Exception $exception) {
            $result = new Result(false);
            $result->setErrorMessage("Couldn't create payment on Mollie: {$exception->getMessage()}");

            return $result;
        }
    }

    /**
     * @param Order $order
     *
     * @return string
     * @throws HttpAuthenticationException
     */
    private function getLinkFromPayment(Order $order)
    {
        $embedded = $order->getEmbedded();
        if(!empty($embedded['payments'][0])) {
            /** @var Payment $payment */
            $payment = $embedded['payments'][0];

            $link = $payment->getLink('changePaymentState');
            if ($link) {
                return $link->getHref();
            }
        }

        throw new HttpAuthenticationException('Redirect link not set in created order');
    }

    /**
     * @return OrderService
     */
    private function _getOrderService()
    {
        if ($this->orderService === null) {
            $this->orderService = ServiceRegister::getService(OrderService::CLASS_NAME);
        }

        return $this->orderService;
    }
}
