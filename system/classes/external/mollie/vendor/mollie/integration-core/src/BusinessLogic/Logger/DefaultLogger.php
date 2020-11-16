<?php

namespace Mollie\BusinessLogic\Logger;

use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\Http\OrgToken\ProxyDataProvider;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\HttpClient;
use Mollie\Infrastructure\Logger\Interfaces\DefaultLoggerAdapter;
use Mollie\Infrastructure\Logger\LogData;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class DefaultLogger
 *
 * @package Mollie\BusinessLogic\Logger
 */
class DefaultLogger implements DefaultLoggerAdapter
{
    /**
     * Log message in system.
     *
     * @param LogData $data
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     */
    public function logMessage(LogData $data)
    {
        /** @var Configuration $config */
        $config = ServiceRegister::getService(Configuration::CLASS_NAME);
        /** @var HttpClient $client */
        $client = ServiceRegister::getService(HttpClient::CLASS_NAME);
        /** @var ProxyDataProvider $transformer */
        $transformer = ServiceRegister::getService(ProxyDataProvider::CLASS_NAME);
        $proxy = new Proxy($config, $client, $transformer);

        $proxy->createLog($data);
    }
}
