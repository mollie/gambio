<?php

namespace Mollie\Gambio\APIProcessor;

use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\Gambio\Mappers\OrderMapper;
use Mollie\Gambio\Services\Business\StatusUpdate;
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

            return new Result(true, $createdOrder->getLink('checkout')->getHref());
        } catch (\Exception $exception) {
            $result = new Result(false);
            $result->setErrorMessage("Couldn't create payment on Mollie: {$exception->getMessage()}");

            return $result;
        }
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
