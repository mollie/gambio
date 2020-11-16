<?php

namespace Mollie\Infrastructure\Utility\Events;

/**
 * Class EventBus
 * @package Mollie\Infrastructure\Utility\Events
 */
class EventBus extends EventEmitter
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var EventBus
     */
    protected static $instance;

    /**
     * EventBus constructor.
     */
    private function __construct()
    {
    }

    /**
     * Returns singleton instance of EventBus.
     *
     * @return EventBus Instance of EventBus class.
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Resets singleton instance. Required for proper tests.
     */
    public static function resetInstance()
    {
        static::$instance = null;
    }

    /**
     * Fires requested event by calling all its registered handlers.
     *
     * @param \Mollie\Infrastructure\Utility\Events\Event $event Event to fire.
     */
    public function fire(Event $event)
    {
        // just changed access type from protected to public
        parent::fire($event);
    }
}
