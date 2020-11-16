<?php

namespace Mollie\Gambio\APIProcessor;

use Mollie\Gambio\APIProcessor\Exceptions\ProcessorNotRegisteredException;
use Mollie\Gambio\APIProcessor\Interfaces\Processor;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;

/**
 * Class ProcessorRegister
 *
 * @package Mollie\BusinessLogic\APIProcessor
 */
class ProcessorRegister
{
    /**
     * Service register instance.
     *
     * @var ProcessorRegister
     */
    private static $instance;
    /**
     * Array of registered services.
     *
     * @var array
     */
    protected $processors;

    /**
     * ProcessorRegister constructor.
     *
     * @throws \InvalidArgumentException
     *  In case delegate of a registered service is not a callable.
     */
    protected function __construct()
    {
        self::$instance = $this;
    }

    /**
     * Getting service register instance
     *
     * @return ProcessorRegister
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ProcessorRegister();
        }

        return self::$instance;
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * Gets service for specified type.
     *
     * @param string $type Type of service. Should be fully qualified class name.
     *
     * @return Processor Instance of service.
     */
    public static function getProcessor($type)
    {
        // Unhandled exception warning suppressed on purpose so that all classes using service
        // would not need @throws tag.
        /** @noinspection PhpUnhandledExceptionInspection */
        return self::getInstance()->_get($type);
    }

    /**
     * Registers processor with delegate as second parameter which represents function for creating new API processor
     * instance.
     *
     * @param string $apiMethod Type of processor. Should be fully qualified class name.
     * @param callable $delegate Delegate that will give instance of registered API processor.
     *
     * @throws \InvalidArgumentException
     *  In case delegate is not a callable.
     */
    public static function registerProcessor($apiMethod, $delegate)
    {
        $allowedMethods = array(PaymentMethodConfig::API_METHOD_ORDERS, PaymentMethodConfig::API_METHOD_PAYMENT);
        if (!in_array($apiMethod, $allowedMethods, true)) {
            throw new \InvalidArgumentException(
                "$apiMethod is not allowed API method. Allowed methods: " . implode(', ', $allowedMethods)
            );
        }

        self::getInstance()->_register($apiMethod, $delegate);
    }

    /**
     * Register service class.
     *
     * @param string $apiMethod API method. Should orders_api or payments_api.
     * @param callable $delegate Delegate that will give instance of registered service.
     *
     * @throws \InvalidArgumentException
     *  In case delegate is not a callable.
     */
    protected function _register($apiMethod, $delegate)
    {
        if (!is_callable($delegate)) {
            throw new \InvalidArgumentException("$apiMethod delegate is not callable.");
        }

        $this->processors[$apiMethod] = $delegate;
    }

    /**
     * Getting processor instance.
     *
     * @param string $apiMethod API method. Should orders_api or payments_api.
     *
     * @return Processor Instance of service.
     *
     * @throws ProcessorNotRegisteredException
     */
    protected function _get($apiMethod)
    {
        if (empty($this->processors[$apiMethod])) {
            throw new ProcessorNotRegisteredException($apiMethod);
        }

        return call_user_func($this->processors[$apiMethod]);
    }
}
