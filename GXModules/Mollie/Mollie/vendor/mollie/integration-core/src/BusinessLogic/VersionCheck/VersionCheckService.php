<?php

namespace Mollie\BusinessLogic\VersionCheck;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\VersionCheck\Http\VersionCheckProxy;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class VersionCheckService
 *
 * @package Mollie\BusinessLogic\VersionCheck
 */
abstract class VersionCheckService extends BaseService
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
     * Fetches the latest plugin version, compares with the current and displays
     * message if version is outdated
     *
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function checkForNewVersion()
    {
        /** @var VersionCheckProxy $proxy */
        $proxy = ServiceRegister::getService(VersionCheckProxy::CLASS_NAME);

        $latestVersion = $proxy->getLatestPluginVersion($this->getConfigService()->getExtensionVersionCheckUrl());
        if (version_compare($latestVersion, $this->getConfigService()->getExtensionVersion(), 'gt')) {
            $this->flashMessage($latestVersion);
        }
    }

    /**
     * Display message in the shop
     *
     * @param string $latestVersion
     */
    abstract protected function flashMessage($latestVersion);

    /**
     * @return Configuration
     */
    protected function getConfigService()
    {
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        return $configService;
    }
}
