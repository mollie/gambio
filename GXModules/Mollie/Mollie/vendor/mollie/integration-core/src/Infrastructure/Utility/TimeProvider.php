<?php

namespace Mollie\Infrastructure\Utility;

use DateTime;

/**
 * Class TimeProvider.
 *
 * @package Mollie\Infrastructure\Utility
 */
class TimeProvider
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance.
     *
     * @var TimeProvider
     */
    protected static $instance;

    /**
     * TimeProvider constructor
     */
    private function __construct()
    {
    }

    /**
     * Returns singleton instance of TimeProvider.
     *
     * @return TimeProvider An instance.
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * Gets current time in default server timezone.
     *
     * @return \DateTime Current time as @see \DateTime object.
     */
    public function getCurrentLocalTime()
    {
        return new DateTime();
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * Returns @see \DateTime object from timestamp.
     *
     * @param int $timestamp Timestamp in seconds.
     *
     * @return \DateTime Object from timestamp.
     */
    public function getDateTime($timestamp)
    {
        return new DateTime("@{$timestamp}");
    }

    /**
     * Returns current timestamp in milliseconds
     *
     * @return int Current time in milliseconds.
     */
    public function getMillisecondsTimestamp()
    {
        return (int)round(microtime(true) * 1000);
    }

    /**
     * Delays execution for sleep time seconds.
     *
     * @param int $sleepTime Sleep time in seconds.
     */
    public function sleep($sleepTime)
    {
        sleep($sleepTime);
    }

    /**
     * Converts serialized string time to DateTime object.
     *
     * @param string $dateTime DateTime in string format.
     * @param string $format DateTime string format.
     *
     * @return \DateTime | null Date or null.
     */
    public function deserializeDateString($dateTime, $format = null)
    {
        if ($dateTime === null) {
            return null;
        }

        return DateTime::createFromFormat($format ?: DATE_ATOM, $dateTime);
    }

    /**
     * Serializes date time object to its string format.
     *
     * @param \DateTime|null $dateTime Date time object to be serialized.
     * @param string $format DateTime string format.
     *
     * @return string|null String serialized date.
     */
    public function serializeDate(DateTime $dateTime = null, $format = null)
    {
        if ($dateTime === null) {
            return null;
        }

        return $dateTime->format($format ?: DATE_ATOM);
    }
}
