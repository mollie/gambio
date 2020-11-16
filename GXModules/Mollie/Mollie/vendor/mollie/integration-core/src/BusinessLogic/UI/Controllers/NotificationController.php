<?php

namespace Mollie\BusinessLogic\UI\Controllers;

use Mollie\BusinessLogic\Notifications\Interfaces\DefaultNotificationChannelAdapter;
use Mollie\BusinessLogic\UI\Controllers\DTO\NotificationListResponse;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class NotificationController
 *
 * @package Mollie\BusinessLogic\UI\Controllers
 */
class NotificationController
{
    /**
     * @var DefaultNotificationChannelAdapter
     */
    protected $defaultNotificationChannel;

    /**
     * Returns paginated notifications and total count
     *
     * @param int $take
     * @param int $skip
     *
     * @return NotificationListResponse
     */
    public function get($take, $skip)
    {
        $channel = $this->getDefaultNotificationChannel();

        return new NotificationListResponse($channel->count(), $channel->get($take, $skip));
    }

    /**
     * Marks notification with provided id as read
     *
     * @param int|string $notificationId
     */
    public function markAsRead($notificationId)
    {
        $this->getDefaultNotificationChannel()->markAsRead($notificationId);
    }

    /**
     * Marks notification with provided id as unread
     *
     * @param int|string $notificationId
     */
    public function markAsUnread($notificationId)
    {
        $this->getDefaultNotificationChannel()->markAsUnread($notificationId);
    }

    /**
     * @return DefaultNotificationChannelAdapter
     */
    protected function getDefaultNotificationChannel()
    {
        if ($this->defaultNotificationChannel === null) {
            $this->defaultNotificationChannel = ServiceRegister::getService(DefaultNotificationChannelAdapter::CLASS_NAME);
        }

        return $this->defaultNotificationChannel;
    }
}
