<?php

use Mollie\BusinessLogic\Integration\Event\IntegrationOrderCanceledEvent;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\EventBus;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class Mollie_OrderActionExtender
 * @see OrderActions
 */
class Mollie_OrderActionExtender extends Mollie_OrderActionExtender_parent
{

    /**
     * @param array $orderIds
     * @param BoolType $restockQuantity
     * @param BoolType $recalculateShippingStatus
     * @param BoolType $resetArticleStatus
     * @param BoolType $notifyCustomer
     * @param BoolType $sendComment
     * @param StringType|null $comment
     * @throws Exception
     */
    public function cancelOrder(
        array $orderIds,
        BoolType $restockQuantity,
        BoolType $recalculateShippingStatus,
        BoolType $resetArticleStatus,
        BoolType $notifyCustomer,
        BoolType $sendComment,
        StringType $comment = null
    ) {
        try {
            /** @var EventBus $eventBus */
            $eventBus = ServiceRegister::getService(EventBus::CLASS_NAME);
            foreach ($orderIds as $orderId) {
                $eventBus->fire(new IntegrationOrderCanceledEvent($orderId));
            }

            parent::cancelOrder(
                $orderIds,
                $restockQuantity,
                $recalculateShippingStatus,
                $resetArticleStatus,
                $notifyCustomer,
                $sendComment,
                $comment
            );
        } catch (\Exception $e) {
            http_response_code(422);
        }
    }
}