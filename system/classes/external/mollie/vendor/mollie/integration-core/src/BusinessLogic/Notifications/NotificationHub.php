<?php

namespace Mollie\BusinessLogic\Notifications;

use Mollie\BusinessLogic\Notifications\Interfaces\DefaultNotificationChannelAdapter;
use Mollie\BusinessLogic\Notifications\Interfaces\ShopNotificationChannelAdapter;
use Mollie\BusinessLogic\Notifications\Model\Notification;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Singleton;
use Mollie\Infrastructure\Utility\TimeProvider;

/**
 * Class NotificationHub
 *
 * @package Mollie\BusinessLogic\Notifications
 */
class NotificationHub extends Singleton
{
    /**
     * Error type of notification.
     */
    const ERROR = 2;
    /**
     * Warning type of notification.
     */
    const WARNING = 1;
    /**
     * Info type of notification.
     */
    const INFO = 0;

    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * @var DefaultNotificationChannelAdapter
     */
    private $defaultNotificationChannel;

    /**
     * NotificationHub constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->defaultNotificationChannel = ServiceRegister::getService(DefaultNotificationChannelAdapter::CLASS_NAME);
    }

    /**
     * Push notification with error severity
     *
     * @param NotificationText $message
     * @param NotificationText $description
     * @param string $orderNumber
     */
    public static function pushError(NotificationText $message, NotificationText $description, $orderNumber = '')
    {
        static::push(self::ERROR, $message, $description, $orderNumber);
    }

    /**
     * Push notification with warning severity
     *
     * @param NotificationText $message
     * @param NotificationText $description
     * @param string $orderNumber
     */
    public static function pushWarning(NotificationText $message, NotificationText $description, $orderNumber = '')
    {
        static::push(self::WARNING, $message, $description, $orderNumber);
    }

    /**
     * Push notification with info severity
     *
     * @param NotificationText $message
     * @param NotificationText $description
     * @param string $orderNumber
     */
    public static function pushInfo(NotificationText $message, NotificationText $description, $orderNumber = '')
    {
        static::push(self::INFO, $message, $description, $orderNumber);
    }

    /**
     * Push notification to default channel and to all shop specific channels if severity is error or warning
     *
     * @param int $severity notification level
     * @param NotificationText $message
     * @param NotificationText $description
     * @param string|int $orderNumber order identifier
     */
    protected static function push($severity, NotificationText $message, NotificationText $description, $orderNumber = '')
    {
        $notification = static::getInstance()->createNotification($severity, $message, $description, $orderNumber);

        static::getInstance()->pushNotification($notification);
    }

    /**
     * Creates notification with given parameters
     *
     * @param int $severity notification level
     * @param NotificationText $message
     * @param NotificationText $description
     * @param string|int $orderNumber order identifier
     *
     * @return Notification
     */
    protected function createNotification($severity, NotificationText $message, NotificationText $description, $orderNumber = '')
    {
        /** @var Configuration $config */
        $config = ServiceRegister::getService(Configuration::CLASS_NAME);
        $notification = new Notification();
        $notification->setMessage($message);
        $notification->setDescription($description);
        $notification->setSeverity($severity);
        $notification->setOrderNumber($orderNumber);
        $notification->setTimestamp(TimeProvider::getInstance()->getCurrentLocalTime()->getTimestamp());
        $notification->setWebsiteId($config->getCurrentSystemId());
        $notification->setWebsiteName($config->getCurrentSystemName());
        $notification->setIsRead(false);

        return $notification;
    }

    /**
     * @param Notification $notification
     */
    protected function pushNotification(Notification $notification)
    {
        $this->defaultNotificationChannel->push($notification);

        if ($notification->getSeverity() > self::INFO) {
            $this->pushNotificationToShopNotificationChannels($notification);
        }
    }

    /**
     * Iterates through all registered shop notification channels and push notification on it
     *
     * @param Notification $notification
     */
    protected function pushNotificationToShopNotificationChannels(Notification $notification)
    {
        /** @var ShopNotificationChannelAdapter $shopNotificationChannels */
        $shopNotificationChannels = ServiceRegister::getService(ShopNotificationChannelAdapter::CLASS_NAME);
        $shopNotificationChannels->push($notification);
    }
}
