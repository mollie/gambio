<?php

namespace Mollie\BusinessLogic\Notifications;

use Mollie\BusinessLogic\Notifications\Interfaces\DefaultNotificationChannelAdapter;
use Mollie\BusinessLogic\Notifications\Model\Notification;
use Mollie\Infrastructure\ORM\Interfaces\RepositoryInterface;
use Mollie\Infrastructure\ORM\QueryFilter\Operators;
use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ORM\RepositoryRegistry;

/**
 * Class DefaultNotificationChannel
 *
 * @package Mollie\BusinessLogic\Notifications
 */
class DefaultNotificationChannel implements DefaultNotificationChannelAdapter
{

    /**
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * @inheritDoc
     *
     * @param Notification $notification
     */
    public function push(Notification $notification)
    {
        $this->getRepository()->save($notification);
    }

    /**
     * @inheritDoc
     *
     * @param int $take
     * @param int $skip
     *
     * @return Notification[]
     * @noinspection PhpDocMissingThrowsInspection
     */
    public function get($take, $skip)
    {
        $queryFilter = new QueryFilter();
        /** @noinspection PhpUnhandledExceptionInspection */
        $queryFilter->setLimit($take)->setOffset($skip)->orderBy('id', QueryFilter::ORDER_DESC);

        /** @var Notification[] $notifications */
        $notifications = $this->getRepository()->select($queryFilter);

        return  $notifications;
    }

    /**
     * Returns total notification count
     *
     * @return int
     */
    public function count()
    {
        return $this->getRepository()->count();
    }

    /**
     * @inheritDoc
     *
     * @param int|string $notificationId
     */
    public function markAsRead($notificationId)
    {
        $this->setReadMarker($notificationId, true);
    }

    /**
     * @inheritDoc
     *
     * @param int|string $notificationId
     */
    public function markAsUnread($notificationId)
    {
        $this->setReadMarker($notificationId, false);
    }

    /**
     * Set isRead flag
     *
     * @param int|string $notificationId
     * @param bool $isRead
     */
    protected function setReadMarker($notificationId, $isRead)
    {
        $notification = $this->getNotificationById($notificationId);
        if ($notification) {
            $notification->setIsRead($isRead);
            $this->getRepository()->update($notification);
        }
    }

    /**
     * Return notification by its identifier
     *
     * @param int|string $notificationId
     *
     * @return Notification|null
     * @noinspection PhpDocMissingThrowsInspection
     */
    protected function getNotificationById($notificationId)
    {
        $filter = new QueryFilter();
        /** @noinspection PhpUnhandledExceptionInspection */
        $filter->where('id', Operators::EQUALS, $notificationId);
        /** @var Notification $notification */
        $notification = $this->getRepository()->selectOne($filter);

        return $notification;
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * Returns repository instance.
     *
     * @return RepositoryInterface Notification repository.
     */
    protected function getRepository()
    {
        if ($this->repository === null) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $this->repository = RepositoryRegistry::getRepository(Notification::getClassName());
        }

        return $this->repository;
    }
}
