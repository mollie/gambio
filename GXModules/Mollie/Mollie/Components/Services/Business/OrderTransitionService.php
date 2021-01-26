<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\BusinessLogic\Integration\Interfaces\OrderTransitionService as BaseService;
use Mollie\Gambio\OrderReset\OrderResetService;
use Mollie\Gambio\Utility\MollieTranslator;

/**
 * Class OrderTransitionService
 *
 * @package Mollie\Gambio\Services\Business
 */
class OrderTransitionService implements BaseService
{

    use StatusUpdate;

    /**
     * @inheritDoc
     */
    public function payOrder($orderId, array $metadata)
    {
        $this->updateStatus($orderId, 'mollie_paid');
    }

    /**
     * @inheritDoc
     */
    public function expireOrder($orderId, array $metadata)
    {
        $comment = $this->getComment('mollie_expired');
        $this->mapToCancelledStatus($orderId, $comment);
        $orderResetService = new OrderResetService();
        $orderResetService->resetOrder($orderId);
    }

    /**
     * @param string $orderId
     * @param array  $metadata
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    public function cancelOrder($orderId, array $metadata)
    {
        $comment = $this->getComment('mollie_canceled');
        $this->mapToCancelledStatus($orderId, $comment);
    }

    /**
     * @inheritDoc
     */
    public function failOrder($orderId, array $metadata)
    {
        $comment = $this->getComment('mollie_failed');
        $this->mapToCancelledStatus($orderId, $comment);
    }

    /**
     * @inheritDoc
     */
    public function completeOrder($orderId, array $metadata)
    {
        $this->payOrder($orderId, $metadata);
    }

    /**
     * @inheritDoc
     */
    public function authorizeOrder($orderId, array $metadata)
    {
        $this->updateStatus($orderId, 'mollie_authorized');
    }

    /**
     * @inheritDoc
     */
    public function refundOrder($orderId, array $metadata)
    {
        $this->updateStatus($orderId, 'mollie_refunded');
    }

    /**
     * @param $orderId
     * @param $comment
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    private function mapToCancelledStatus($orderId, $comment)
    {
        $this->updateStatus($orderId, 'mollie_canceled', $comment);
    }

    /**
     * @param string $statusCode
     *
     * @return string
     */
    private function getComment($statusCode)
    {
        $translate = new MollieTranslator();

        return $translate->translate("{$statusCode}_comment");
    }
}
