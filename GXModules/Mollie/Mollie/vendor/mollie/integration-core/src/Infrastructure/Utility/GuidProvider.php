<?php

namespace Mollie\Infrastructure\Utility;

/**
 * Class GuidProvider.
 *
 * @package Mollie\Infrastructure\Utility
 */
class GuidProvider
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var GuidProvider
     */
    protected static $instance;

    /**
     * GuidProvider constructor.
     */
    private function __construct()
    {
    }

    /**
     * Returns singleton instance of GuidProvider.
     *
     * @return GuidProvider Instance of GuidProvider class.
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Generates random string.
     *
     * @return string Generated string.
     */
    public function generateGuid()
    {
        return uniqid(getmypid() . '_', true);
    }
}
