<?php

namespace Mollie\Gambio\Services\Infrastructure;

use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\Logger\Interfaces\ShopLoggerAdapter;
use Mollie\Infrastructure\Logger\LogData;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class LoggerService
 *
 * @package Mollie\Gambio\Services
 */
class LoggerService implements ShopLoggerAdapter
{
    const LOG_MESSAGE_FORMAT = ":level [:datetime][:component] :message\n";

    /**
     * Log level names for corresponding log level codes.
     *
     * @var array
     */
    protected static $logLevelName = [
        Logger::ERROR => 'ERROR',
        Logger::WARNING => 'WARNING',
        Logger::INFO => 'INFO',
        Logger::DEBUG => 'DEBUG',
    ];

    /**
     * @param LogData $data
     */
    public function logMessage(LogData $data)
    {
        if (!$this->_isLoggingAllowed($data)) {
            return;
        }

        /** @var \FileLog $shopLogger */
        $shopLogger = \MainFactory::create('FileLog', 'mollie');

        $shopLogger->write($this->_getLogMessage($data));
    }

    /**
     * @param LogData $logData
     *
     * @return string
     */
    private function _getLogMessage(LogData $logData)
    {
        // timestamp is crated in milliseconds
        $timestamp = (int)($logData->getTimestamp() / 1000);
        $date = new \DateTime("@{$timestamp}");
        $args = [
            ':level'     => static::$logLevelName[$logData->getLogLevel()],
            ':datetime'  => $date->format(DATE_ATOM),
            ':component' => $logData->getComponent(),
            ':message'   => $logData->getMessage(),
        ];

        return strtr(static::LOG_MESSAGE_FORMAT, $args);
    }

    /**
     * @param LogData $data
     *
     * @return bool
     */
    private function _isLoggingAllowed(LogData $data)
    {
        /** @var Configuration $configService */
        $configService      = ServiceRegister::getService(Configuration::CLASS_NAME);
        $minLogLevel        = $configService->getMinLogLevel();
        $isDebugModeEnabled = $configService->isDebugModeEnabled();

        return (($minLogLevel >= $data->getLogLevel()) || $isDebugModeEnabled);
    }
}
