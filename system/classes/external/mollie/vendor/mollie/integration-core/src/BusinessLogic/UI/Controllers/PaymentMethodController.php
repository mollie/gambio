<?php

namespace Mollie\BusinessLogic\UI\Controllers;

use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethodService;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class PaymentMethodController
 *
 * @package Mollie\BusinessLogic\UI\Controllers
 */
class PaymentMethodController
{

    /**
     * Gets list of payment method configurations for all available Mollie payment methods.
     *
     * @param string $profileId Website profile id
     *
     * @return PaymentMethodConfig[]
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getAll($profileId)
    {
        /** @var PaymentMethodService $paymentMethodService */
        $paymentMethodService = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        return $paymentMethodService->getAllPaymentMethodConfigurations($profileId);
    }

    /**
     * Gets list of payment method configurations for enabled Mollie payment methods.
     *
     * @param string $profileId Website profile id
     * @param string|null $billingCountry The billing country of your customer in ISO 3166-1 alpha-2 format.
     * @param Amount|null $amount
     * @param string $apiMethod Api method to use for availability checking. Default is orders api
     *
     * @return PaymentMethodConfig[]
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function getEnabled(
        $profileId,
        $billingCountry = null,
        $amount = null,
        $apiMethod = PaymentMethodConfig::API_METHOD_ORDERS
    ) {
        /** @var PaymentMethodService $paymentMethodService */
        $paymentMethodService = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        return $paymentMethodService->getEnabledPaymentMethodConfigurations(
            $profileId,
            $billingCountry,
            $amount,
            $apiMethod
        );
    }

    /**
     * Saves list of payment method configurations
     *
     * @param PaymentMethodConfig[] $paymentMethodConfigs
     *
     * @throws RepositoryNotRegisteredException
     */
    public function save(array $paymentMethodConfigs)
    {
        $paymentMethodConfigsRepo = RepositoryRegistry::getRepository(PaymentMethodConfig::CLASS_NAME);
        foreach ($paymentMethodConfigs as $paymentMethodConfig) {
            if ($paymentMethodConfig->getId()) {
                $paymentMethodConfigsRepo->update($paymentMethodConfig);
            } else {
                $paymentMethodConfigsRepo->save($paymentMethodConfig);
            }
        }
    }
}
