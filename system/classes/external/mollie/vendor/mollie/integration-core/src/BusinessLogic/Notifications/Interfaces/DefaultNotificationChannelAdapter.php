<?php

namespace Mollie\BusinessLogic\Notifications\Interfaces;

use Mollie\BusinessLogic\Notifications\Model\Notification;

/**
 * Interface DefaultNotificationChannelAdapter
 *
 * @package Mollie\BusinessLogic\Notifications\Interfaces
 */
interface DefaultNotificationChannelAdapter extends NotificationChannelAdapter
{
    const CLASS_NAME = __CLASS__;

    /**
     * Returns notifications paginated
     *
     * @param int $take query limit
     * @param int $skip query offset
     *
     * @return Notification[]
     */
    public function get($take, $skip);

    /**
     * Returns total notification count
     *
     * @return int
     */
    public function count();

    /**
     * Marks notification as read
     *
     * @param int|string $notificationId
     */
    public function markAsRead($notificationId);

    /**
     * Marks notification as unread
     *
     * @param int|string $notificationId
     */
    public function markAsUnread($notificationId);
}
