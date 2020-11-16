<?php


namespace Mollie\Gambio\APIProcessor;

use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Gambio\APIProcessor\Exceptions\PaymentMethodConfigNotFoundException;
use Mollie\Gambio\APIProcessor\Exceptions\ProfileNotFoundException;
use Mollie\Gambio\APIProcessor\Interfaces\Processor;
use Mollie\BusinessLogic\Http\DTO\WebsiteProfile;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethodService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class ProcessorFactory
 *
 * @package Mollie\BusinessLogic\APIProcessor
 */
class ProcessorFactory
{
    /**
     * @var PaymentMethodService
     */
    protected $paymentMethodService;

    protected static $instance;

    /**
     * ProcessorFactory constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @param string $methodId
     *
     * @return Processor|Interfaces\Processor
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public static function createProcessor($methodId)
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        $methodConfig = static::$instance->_getPaymentMethodConfig($methodId);

        return ProcessorRegister::getProcessor($methodConfig->getApiMethod());
    }

    /**
     * @param string $methodId
     *
     * @return \Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     * @throws PaymentMethodConfigNotFoundException
     * @throws ProfileNotFoundException
     */
    protected function _getPaymentMethodConfig($methodId)
    {
        /** @var PaymentMethodService $paymentMethodService */
        $paymentMethodService = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        /** @var WebsiteProfile $websiteProfile */
        $websiteProfile = $configService->getWebsiteProfile();
        if ($websiteProfile === null) {
            throw new ProfileNotFoundException('Website profile is not set');
        }

        $paymentMethodConfig = $paymentMethodService->getAllPaymentMethodConfigurations($websiteProfile->getId());

        return $this->_getConfigById($paymentMethodConfig, $methodId);
    }

    /**
     * @param PaymentMethodConfig[] $paymentMethodConfigs
     * @param string                $methodId
     *
     * @return PaymentMethodConfig
     * @throws PaymentMethodConfigNotFoundException
     */
    protected function _getConfigById($paymentMethodConfigs, $methodId)
    {
        foreach ($paymentMethodConfigs as $methodConfig) {
            if ($methodConfig->getId() === $methodId) {
                return $methodConfig;
            }
        }

        throw new PaymentMethodConfigNotFoundException("Configuration not found for {$methodId}");
    }
}
