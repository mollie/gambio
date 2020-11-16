<?php

namespace Mollie\BusinessLogic\UI\Controllers\DTO;

use Mollie\BusinessLogic\Notifications\Model\Notification;

/**
 * Class NotificationListResponse
 *
 * @package Mollie\BusinessLogic\UI\Controllers\DTO
 */
class NotificationListResponse
{
    /**
     * @var int
     */
    private $totalCount;
    /**
     * @var Notification[]
     */
    private $notifications;

    /**
     * NotificationListResponse constructor.
     *
     * @param int $totalCount
     * @param Notification[] $notifications
     */
    public function __construct($totalCount, array $notifications)
    {
        $this->totalCount = $totalCount;
        $this->notifications = $notifications;
    }

    /**
     * Returns total number of notifications
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * Returns notifications fetched in query
     *
     * @return array
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}
