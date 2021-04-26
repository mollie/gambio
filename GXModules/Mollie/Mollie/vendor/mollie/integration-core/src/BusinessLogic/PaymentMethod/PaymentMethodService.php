<?php

namespace Mollie\BusinessLogic\PaymentMethod;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ORM\QueryFilter\Operators;
use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class PaymentMethodService
 *
 * @package Mollie\BusinessLogic\PaymentMethod
 */
class PaymentMethodService extends BaseService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Gets list of payment method configurations for all available Mollie payment methods.
     *
     * @param string $profileId
     *
     * @return PaymentMethodConfig[] Payment method configurations for every available Mollie payment method
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getAllPaymentMethodConfigurations($profileId)
    {
        $paymentMethodConfigs = array();

        $allPaymentMethods = $this->getProxy()->getAllPaymentMethods();
        $enabledPaymentMethods = $this->getProxy()->getEnabledPaymentMethodsMap();
        $savedPaymentMethodConfigs = $this->getPaymentMethodConfigurationsMap($profileId);

        foreach ($allPaymentMethods as $paymentMethod) {
            $paymentMethodConfig = new PaymentMethodConfig();
            $paymentMethodConfig->setProfileId($profileId);
            if (array_key_exists($paymentMethod->getId(), $savedPaymentMethodConfigs)) {
                $paymentMethodConfig = $savedPaymentMethodConfigs[$paymentMethod->getId()];
            }

            $paymentMethodConfig->setOriginalAPIConfig($paymentMethod);
            $paymentMethodConfig->setEnabled(array_key_exists($paymentMethod->getId(), $enabledPaymentMethods));

            $paymentMethodConfigs[] = $paymentMethodConfig;
        }

        return $paymentMethodConfigs;
    }

    /**
     * Gets list of payment method configurations for enabled Mollie payment methods.
     *
     * @param string $profileId
     * @param string|null $billingCountry The billing country of your customer in ISO 3166-1 alpha-2 format.
     * @param Amount|null $amount
     * @param string $apiMethod Api method to use for availability checking. Default is orders api
     * @param array $orderLineCategories
     *
     * @return PaymentMethodConfig[] Payment method configurations for every enabled Mollie payment method
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabledPaymentMethodConfigurations(
        $profileId,
        $billingCountry = null,
        $amount = null,
        $apiMethod = PaymentMethodConfig::API_METHOD_ORDERS,
        $orderLineCategories = array()
    ) {
        $paymentMethodConfigs = array();

        $enabledPaymentMethods = $this->getProxy()->getEnabledPaymentMethodsMap($billingCountry, $amount, $apiMethod,
            $orderLineCategories);
        $savedPaymentMethodConfigs = $this->getPaymentMethodConfigurationsMap($profileId);

        foreach ($enabledPaymentMethods as $paymentMethod) {
            $paymentMethodConfig = new PaymentMethodConfig();
            $paymentMethodConfig->setProfileId($profileId);
            if (array_key_exists($paymentMethod->getId(), $savedPaymentMethodConfigs)) {
                $paymentMethodConfig = $savedPaymentMethodConfigs[$paymentMethod->getId()];
            }

            $paymentMethodConfig->setOriginalAPIConfig($paymentMethod);
            $paymentMethodConfig->setEnabled(true);

            $paymentMethodConfigs[] = $paymentMethodConfig;
        }

        return $paymentMethodConfigs;
    }

    /**
     * Returns enabled payment methods for the passed API key
     *
     * @param string $apiKey temporary API key
     *
     * @return \Mollie\BusinessLogic\Http\DTO\PaymentMethod[]
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabledPaymentMethodsWithTempAPIKey($apiKey)
    {
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $currentToken = $configService->getAuthorizationToken();
        $configService->setAuthorizationToken($apiKey);

        $enabledMethods = $this->getProxy()->getEnabledPaymentMethods();
        $configService->setAuthorizationToken($currentToken);

        return $enabledMethods;
    }

    /**
     * Return enabled
     * @param string $profileId
     *
     * @return \Mollie\BusinessLogic\Http\DTO\PaymentMethod[]
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabledMethodsWithTempProfileId($profileId)
    {
        return $this->getProxy()->getEnabledPaymentMethodsForProfile($profileId);
    }

    /**
     * Clears all payment method configurations for a given profile
     *
     * @param string $profileId
     */
    public function clear($profileId)
    {
        $this->getRepository(PaymentMethodConfig::CLASS_NAME)->deleteBy(
            $this->setFilterCondition(new QueryFilter(), 'profileId', Operators::EQUALS, $profileId)
        );
    }

    /**
     * Clears all payment method configurations except configurations for a given profile
     *
     * @param string $profileId Profile id for which configuration should be kept. All configs related to other profiles will
     * be removed!
     */
    public function clearAllOther($profileId)
    {
        $this->getRepository(PaymentMethodConfig::CLASS_NAME)->deleteBy(
            $this->setFilterCondition(new QueryFilter(), 'profileId', Operators::NOT_EQUALS, $profileId)
        );
    }

    /**
     * @param string $profileId
     *
     * @return PaymentMethodConfig[]
     */
    protected function getPaymentMethodConfigurationsMap($profileId)
    {
        $paymentMethodConfigsMap = array();

        /** @var PaymentMethodConfig[] $paymentMethodConfigs */
        $paymentMethodConfigs = $this->getRepository(PaymentMethodConfig::CLASS_NAME)->select(
            $this->setFilterCondition(new QueryFilter(), 'profileId', Operators::EQUALS, $profileId)
        );

        foreach ($paymentMethodConfigs as $paymentMethodConfig) {
            $paymentMethodConfigsMap[$paymentMethodConfig->getMollieId()] = $paymentMethodConfig;
        }

        return $paymentMethodConfigsMap;
    }

    /**
     * @return Configuration|object
     */
    protected function getConfigService()
    {
        return ServiceRegister::getService(Configuration::CLASS_NAME);
    }
}
