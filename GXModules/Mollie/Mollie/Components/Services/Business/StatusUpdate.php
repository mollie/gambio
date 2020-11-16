<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\Gambio\Mappers\OrderStatusMapper;

/**
 * Trait StatusUpdate
 *
 * @package Mollie\Gambio\Services\Business
 */
trait StatusUpdate
{
    /**
     * @var \OrderWriteServiceInterface
     */
    protected $orderWriteService;
    /**
     * @var OrderStatusMapper
     */
    protected $statusMapper;
    /**
     * @param int    $orderId
     * @param int    $mollieStatus
     * @param string $comment
     * @param bool   $customerNotified
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    protected function updateStatus($orderId, $mollieStatus, $comment = '', $customerNotified = false)
    {
        $statusId = $this->getOrderStatusMapper()->mapToGambioStatus($mollieStatus);

        $this->getOrderWriteService()->updateOrderStatus(
            new \IdType($orderId),
            new \IdType($statusId),
            new \StringType($comment),
            new \BoolType($customerNotified)
        );
    }

    /**
     * @return \OrderWriteServiceInterface
     */
    protected function getOrderWriteService()
    {
        if ($this->orderWriteService === null) {
            $this->orderWriteService = \StaticGXCoreLoader::getService('OrderWrite');
        }

        return $this->orderWriteService;
    }

    /**
     * @return OrderStatusMapper
     */
    protected function getOrderStatusMapper()
    {
        if ($this->statusMapper === null) {
            $this->statusMapper = new OrderStatusMapper();
        }

        return $this->statusMapper;
    }
}
