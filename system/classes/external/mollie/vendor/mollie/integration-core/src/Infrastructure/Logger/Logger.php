<?php

namespace Mollie\Infrastructure\Logger;

use Mollie\Infrastructure\Logger\Interfaces\DefaultLoggerAdapter;
use Mollie\Infrastructure\Logger\Interfaces\ShopLoggerAdapter;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Singleton;
use Mollie\Infrastructure\Utility\TimeProvider;

/**
 * Class Logger.
 *
 * @package Mollie\Infrastructure\Logger
 */
class Logger extends Singleton
{
    /**
     * Error type of log.
     */
    const ERROR = 0;
    /**
     * Warning type of log.
     */
    const WARNING = 1;
    /**
     * Info type of log.
     */
    const INFO = 2;
    /**
     * Debug type of log.
     */
    const DEBUG = 3;
    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;
    /**
     * Shop logger.
     *
     * @var ShopLoggerAdapter
     */
    private $shopLogger;
    /**
     * Time provider.
     *
     * @var TimeProvider
     */
    private $timeProvider;

    /**
     * Logger constructor. Hidden.
     */
    protected function __construct()
    {
        parent::__construct();

        $this->shopLogger = ServiceRegister::getService(ShopLoggerAdapter::CLASS_NAME);
        $this->timeProvider = ServiceRegister::getService(TimeProvider::CLASS_NAME);
    }

    /**
     * Logs error message.
     *
     * @param string $message Message to log.
     * @param string $component Component for which to log message.
     * @param LogContextData[] $context Additional context data.
     */
    public static function logError($message, $component = 'Core', array $context = array())
    {
        self::getInstance()->logMessage(self::ERROR, $message, $component, $context);
    }

    /**
     * Logs warning message.
     *
     * @param string $message Message to log.
     * @param string $component Component for which to log message.
     * @param LogContextData[] $context Additional context data.
     */
    public static function logWarning($message, $component = 'Core', array $context = array())
    {
        self::getInstance()->logMessage(self::WARNING, $message, $component, $context);
    }

    /**
     * Logs info message.
     *
     * @param string $message Message to log.
     * @param string $component Component for which to log message.
     * @param LogContextData[] $context Additional context data.
     */
    public static function logInfo($message, $component = 'Core', array $context = array())
    {
        self::getInstance()->logMessage(self::INFO, $message, $component, $context);
    }

    /**
     * Logs debug message.
     *
     * @param string $message Message to log.
     * @param string $component Component for which to log message.
     * @param LogContextData[] $context Additional context data.
     */
    public static function logDebug($message, $component = 'Core', array $context = array())
    {
        self::getInstance()->logMessage(self::DEBUG, $message, $component, $context);
    }

    /**
     * Logs message.
     *
     * @param int $level Log level.
     * @param string $message Message to log.
     * @param string $component Component for which to log message.
     * @param LogContextData[] $context Additional context data.
     */
    private function logMessage($level, $message, $component, array $context = array())
    {
        $config = LoggerConfiguration::getInstance();
        $logData = new LogData(
            $config->getIntegrationName(),
            $level,
            $this->timeProvider->getMillisecondsTimestamp(),
            $component,
            $message,
            $context
        );

        // If default logger is turned on and message level is lower or equal than set in configuration
        if ($config->isDefaultLoggerEnabled() && $level <= $config->getMinLogLevel()) {
            $defaultLogger = ServiceRegister::getService(DefaultLoggerAdapter::CLASS_NAME);
            $defaultLogger->logMessage($logData);
        }

        $this->shopLogger->logMessage($logData);
    }
}
