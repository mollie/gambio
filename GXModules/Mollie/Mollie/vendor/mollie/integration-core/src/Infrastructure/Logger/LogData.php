<?php

namespace Mollie\Infrastructure\Logger;

/**
 * Class LogData.
 *
 * @package Mollie\Infrastructure\Logger
 */
class LogData
{
    /**
     * Name of the integration.
     *
     * @var string
     */
    private $integration;
    /**
     * Array of LogContextData.
     *
     * @var LogContextData[]
     */
    private $context;
    /**
     * Log level.
     *
     * @var int
     */
    private $logLevel;
    /**
     * Log timestamp.
     *
     * @var int
     */
    private $timestamp;
    /**
     * Name of the component.
     *
     * @var string
     */
    private $component;
    /**
     * Log message.
     *
     * @var string
     */
    private $message;

    /**
     * LogData constructor.
     *
     * @param string $integration Name of integration.
     * @param int $logLevel Log level. Use constants in @see Logger class.
     * @param int $timestamp Log timestamp.
     * @param string $component Name of the log component.
     * @param string $message Log message.
     * @param array $context Log contexts as an array of @see LogContextData or as key value entries.
     */
    public function __construct($integration, $logLevel, $timestamp, $component, $message, array $context = array())
    {
        $this->integration = $integration;
        $this->logLevel = $logLevel;
        $this->component = $component;
        $this->timestamp = $timestamp;
        $this->message = $message;
        $this->context = array();

        foreach ($context as $key => $item) {
            if (!($item instanceof LogContextData)) {
                $item = new LogContextData($key, $item);
            }

            $this->context[] = $item;
        }
    }

    /**
     * Gets name of the integration.
     *
     * @return string Name of the integration.
     */
    public function getIntegration()
    {
        return $this->integration;
    }

    /**
     * Gets context data array.
     *
     * @return LogContextData[] Array of LogContextData.
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Gets log level.
     *
     * @return int
     *   Log level:
     *    - error => 0
     *    - warning => 1
     *    - info => 2
     *    - debug => 3
     */
    public function getLogLevel()
    {
        return $this->logLevel;
    }

    /**
     * Gets timestamp in seconds.
     *
     * @return int Log timestamp.
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Gets log component.
     *
     * @return string Log component.
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Gets log message.
     *
     * @return string Log message.
     */
    public function getMessage()
    {
        return $this->message;
    }
}
