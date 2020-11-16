<?php

namespace Mollie\BusinessLogic\Notifications\Interfaces;

use Mollie\BusinessLogic\Notifications\Model\Notification;

/**
 * Interface NotificationChannel
 *
 * @package Mollie\BusinessLogic\Notifications\Interfaces
 */
interface NotificationChannelAdapter
{

    /**
     *
     * @param Notification $notification
     */
    public function push(Notification $notification);
}
