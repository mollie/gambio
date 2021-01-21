<?php

use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;

require_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/autoload.php';

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
            foreach ($orderIds as $orderId) {

                NotificationHub::pushInfo(
                    new NotificationText('mollie.payment.integration.event.notification.order_cancel.title'),
                    new NotificationText('mollie.payment.integration.event.notification.order_cancel.description'),
                    $orderId
                );
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