<?php

namespace Mollie\Infrastructure\Utility\Events;

/**
 * Class EventEmitter.
 *
 * @package Mollie\Infrastructure\Utility\Events
 */
abstract class EventEmitter
{
    /**
     * Event handlers array. Key is Fully qualified class name of desired event
     * and value is array of callbacks to invoke when event occurs.
     *
     * @var array
     */
    protected $handlers = array();

    /**
     * Registers event handler for a given event.
     *
     * @param string $eventClass Fully qualified class name of desired event.
     * @param callable $handler Callback to invoke when event occurs.
     *      Observable will pass observed event instance as a handler parameter.
     */
    public function when($eventClass, $handler)
    {
        $this->handlers[$eventClass][] = $handler;
    }

    /**
     * Fires requested event by calling all its registered handlers.
     *
     * @param \Mollie\Infrastructure\Utility\Events\Event $event Event to fire.
     */
    protected function fire(Event $event)
    {
        $eventClass = get_class($event);
        if (!empty($this->handlers[$eventClass])) {
            foreach ($this->handlers[$eventClass] as $handler) {
                call_user_func($handler, $event);
            }
        }
    }
}
