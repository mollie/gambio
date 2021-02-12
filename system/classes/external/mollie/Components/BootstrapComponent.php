<?php

namespace Mollie\Gambio;

use Mollie\BusinessLogic\Authorization\ApiKey\ApiKeyAuthService;
use Mollie\BusinessLogic\Authorization\Interfaces\AuthorizationService;
use Mollie\BusinessLogic\Http\ApiKey\ProxyDataProvider;
use Mollie\BusinessLogic\Integration\Interfaces\OrderLineTransitionService;
use Mollie\BusinessLogic\Integration\Interfaces\OrderTransitionService;
use Mollie\BusinessLogic\Notifications\Model\Notification;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\PaymentMethod\PaymentTransactionDescriptionService;
use Mollie\BusinessLogic\VersionCheck\VersionCheckService;
use Mollie\Gambio\APIProcessor\OrderProcessor;
use Mollie\Gambio\APIProcessor\PaymentProcessor;
use Mollie\Gambio\APIProcessor\ProcessorRegister;
use Mollie\Gambio\Entity\Repository\BaseRepository;
use Mollie\Gambio\Entity\StatusMapping;
use Mollie\Gambio\Mappers\OrderMapper;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Gambio\Services\Business\PaymentMethodService;
use Mollie\Gambio\Services\Business\TransactionDescriptionService;
use Mollie\Gambio\Services\Infrastructure\LoggerService;
use Mollie\Infrastructure\Configuration\ConfigEntity;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\Http\CurlHttpClient;
use Mollie\Infrastructure\Http\HttpClient;
use Mollie\Infrastructure\Logger\Interfaces\ShopLoggerAdapter;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class BootstrapComponent
 *
 * @package Mollie\Gambio
 */
class BootstrapComponent extends \Mollie\BusinessLogic\BootstrapComponent
{
    protected static function initServices()
    {
        parent::initServices();

        ServiceRegister::registerService(
            ShopLoggerAdapter::CLASS_NAME,
            static function () {
                return new LoggerService();
            }
        );

        ServiceRegister::registerService(
            AuthorizationService::CLASS_NAME,
            static function () {
                return ApiKeyAuthService::getInstance();
            }
        );

        ServiceRegister::registerService(
            ProxyDataProvider::CLASS_NAME,
            static function () {
                return new ProxyDataProvider();
            }
        );

        ServiceRegister::registerService(
            Configuration::CLASS_NAME,
            static function () {
                return ConfigurationService::getInstance();
            }
        );

        ServiceRegister::registerService(
            HttpClient::CLASS_NAME,
            static function () {
                return new CurlHttpClient();
            }
        );

        ServiceRegister::registerService(
            PaymentMethodService::CLASS_NAME,
            static function () {
                return PaymentMethodService::getInstance();
            }
        );

        ServiceRegister::registerService(
            OrderTransitionService::CLASS_NAME,
            static function () {
                return new Services\Business\OrderTransitionService();
            }
        );

        ServiceRegister::registerService(
            OrderLineTransitionService::CLASS_NAME,
            static function () {
                return new Services\Business\OrderLineTransitionService();
            }
        );
        ServiceRegister::registerService(
            PaymentTransactionDescriptionService::CLASS_NAME,
            static function () {
                return TransactionDescriptionService::getInstance();
            }
        );

        ServiceRegister::registerService(
            VersionCheckService::CLASS_NAME,
            static function () {
                return Services\Business\VersionCheckService::getInstance();
            }
        );



        static::initProcessors();
    }

    /**
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryClassException
     */
    protected static function initRepositories()
    {
        parent::initRepositories();
        RepositoryRegistry::registerRepository(ConfigEntity::getClassName(), BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(PaymentMethodConfig::getClassName(), BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(Notification::getClassName(), BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(StatusMapping::getClassName(), BaseRepository::getClassName());
        RepositoryRegistry::registerRepository(OrderReference::getClassName(), BaseRepository::getClassName());
    }

    /**
     *
     */
    protected static function initProcessors()
    {
        $mapper = new OrderMapper();

        ProcessorRegister::registerProcessor(
            PaymentMethodConfig::API_METHOD_PAYMENT,
            static function () use ($mapper){
                return new PaymentProcessor($mapper);
            }
        );

        ProcessorRegister::registerProcessor(
            PaymentMethodConfig::API_METHOD_ORDERS,
            static function () use ($mapper){
                return new OrderProcessor($mapper);
            }
        );
    }
}
