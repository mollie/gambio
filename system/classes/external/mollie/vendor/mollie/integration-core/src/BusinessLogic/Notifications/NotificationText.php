<?php

namespace Mollie\BusinessLogic\Notifications;

/**
 * Class NotificationText
 *
 * @package Mollie\BusinessLogic\Notifications
 */
class NotificationText
{
    /**
     * @var string
     */
    private $messageKey;
    /**
     * @var array
     */
    private $messageParams;

    /**
     * NotificationText constructor.
     *
     * @param $messageKey
     * @param array $messageParams
     */
    public function __construct($messageKey, array $messageParams = array())
    {
        $this->messageKey = $messageKey;
        $this->messageParams = $messageParams;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'key' => $this->messageKey,
            'params' => $this->messageParams,
        );
    }

    /**
     * @param $data
     *
     * @return $this
     */
    public static function fromArray($data)
    {
        return new static($data['key'], (array)$data['params']);
    }

    /**
     * @return string
     */
    public function getMessageKey()
    {
        return $this->messageKey;
    }

    /**
     * @return array
     */
    public function getMessageParams()
    {
        return $this->messageParams;
    }
}
