<?php

namespace Mollie\Infrastructure\Logger\Interfaces;

use Mollie\Infrastructure\Logger\LogData;

/**
 * Interface LoggerAdapter.
 *
 * @package Mollie\Infrastructure\Logger\Interfaces
 */
interface LoggerAdapter
{
    /**
     * Log message in system
     *
     * @param LogData $data
     */
    public function logMessage(LogData $data);
}
