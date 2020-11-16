<?php

namespace Mollie\BusinessLogic\Notifications\Model;

use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\Infrastructure\ORM\Configuration\EntityConfiguration;
use Mollie\Infrastructure\ORM\Configuration\IndexMap;
use Mollie\Infrastructure\ORM\Entity;
/**
 * Class Notification
 *
 * @package Mollie\BusinessLogic\Notifications\Model
 */
class Notification extends Entity
{

    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * @var int
     */
    protected $severity;
    /**
     * @var NotificationText
     */
    protected $message;
    /**
     * @var NotificationText
     */
    protected $description;
    /**
     * @var int
     */
    protected $timestamp;
    /**
     * @var int|string
     */
    protected $orderNumber;
    /**
     * @var bool
     */
    protected $isRead;
    /**
     * @var string
     */
    protected $websiteId;
    /**
     * @var string
     */
    protected $websiteName;


    protected $fields = array(
        'id', 'severity', 'websiteId', 'websiteName', 'orderNumber', 'isRead', 'message', 'description', 'timestamp'
    );

    public function getConfig()
    {
        $map = new IndexMap();
        $map->addIntegerIndex('severity')
            ->addIntegerIndex('timestamp')
            ->addStringIndex('websiteId');

        return new EntityConfiguration($map, 'Notification');
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['message'] = $this->message->toArray();
        $data['description'] = $this->description->toArray();

        return $data;
    }

    /**
     * @inheritDoc
     *
     * @param array $data
     */
    public function inflate(array $data)
    {
        parent::inflate($data);
        if (!empty($data['message'])) {
            $this->message = NotificationText::fromArray($data['message']);
        }

        if (!empty($data['description'])) {
            $this->description = NotificationText::fromArray($data['description']);
        }
    }

    /**
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * @param int $severity
     */
    public function setSeverity($severity)
    {
        $this->severity = $severity;
    }

    /**
     * @return NotificationText
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param NotificationText $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return NotificationText
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param NotificationText $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return int|string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param int|string $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return string
     */
    public function getWebsiteId()
    {
        return $this->websiteId;
    }

    /**
     * @param string $websiteId
     */
    public function setWebsiteId($websiteId)
    {
        $this->websiteId = $websiteId;
    }

    /**
     * @return string
     */
    public function getWebsiteName()
    {
        return $this->websiteName;
    }

    /**
     * @param string $websiteName
     */
    public function setWebsiteName($websiteName)
    {
        $this->websiteName = $websiteName;
    }

    /**
     * @return bool
     */
    public function isRead()
    {
        return $this->isRead;
    }

    /**
     * @param bool $isRead
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;
    }
}
