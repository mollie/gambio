<?php

namespace Mollie\Infrastructure;

use Mollie\Infrastructure\Utility\Events\EventBus;
use Mollie\Infrastructure\Utility\GuidProvider;
use Mollie\Infrastructure\Utility\TimeProvider;

/**
 * Class BootstrapComponent.
 *
 * @package Mollie\Infrastructure
 */
class BootstrapComponent
{
    /**
     * Initializes infrastructure components.
     */
    public static function init()
    {
        static::initServices();
        static::initRepositories();
        static::initEvents();
    }

    /**
     * Initializes services and utilities.
     */
    protected static function initServices()
    {
        ServiceRegister::registerService(
            TimeProvider::CLASS_NAME,
            function () {
                return TimeProvider::getInstance();
            }
        );
        ServiceRegister::registerService(
            GuidProvider::CLASS_NAME,
            function () {
                return GuidProvider::getInstance();
            }
        );
        ServiceRegister::registerService(
            EventBus::CLASS_NAME,
            function () {
                return EventBus::getInstance();
            }
        );
    }

    /**
     * Initializes repositories.
     */
    protected static function initRepositories()
    {
    }

    /**
     * Initializes events.
     */
    protected static function initEvents()
    {
    }
}
