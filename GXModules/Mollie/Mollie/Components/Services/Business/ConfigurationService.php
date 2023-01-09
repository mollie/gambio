<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\BusinessLogic\Configuration;
use Mollie\Gambio\Utility\UrlProvider;

/**
 * Class ConfigurationService
 *
 * @package Mollie\Gambio\Services
 */
class ConfigurationService extends Configuration
{
    const VERSION_CHECK_URL = 'https://raw.githubusercontent.com/mollie/gambio/4.5-4.x/GXModules/Mollie/Mollie/composer.json';
    const PLUGIN_DOWNLOAD_URL = 'https://github.com/mollie/gambio/releases';

    /**
     * @inheritDoc
     */
    public function getIntegrationVersion()
    {
        include DIR_FS_CATALOG . '/release_info.php';

        return $gx_version;
    }

    /**
     * @inheritDoc
     */
    public function getExtensionName()
    {
        return 'MollieGambio';
    }

    /**
     * @inheritDoc
     */
    public function getIntegrationName()
    {
        return 'gambio';
    }

    /**
     * @inheritDoc
     */
    public function getCurrentSystemId()
    {
        return '1';
    }

    /**
     * @inheritDoc
     */
    public function getCurrentSystemName()
    {
        return 'gambio - ' . STORE_NAME;
    }

    /**
     * @inheritDoc
     */
    public function getExtensionVersion()
    {
        $composerContent = json_decode(file_get_contents(__DIR__ . '/../../../composer.json'), true);

        return $composerContent['version'];
    }

    /**
     * @return string|string[]
     */
    public function getWebhookUrl()
    {
        $url = UrlProvider::generateShopUrl('shop.php', 'MollieWebhook');
        $debugUrl = $this->getDebugUrl();
        if (!empty($debugUrl)) {
            $baseUrl = rtrim(UrlProvider::generateShopUrl(''), '/');
            $url = str_replace($baseUrl, $debugUrl, $url);
        }

        return $url;
    }

    /**
     * Returns debug url for local env
     *
     * @return string
     */
    public function getDebugUrl()
    {
        return '';
    }

    /**
     * Returns default orders mapping (created in gambio config table, upon plugin install)
     *
     * @return array
     */
    public function getDefaultOrderMapping()
    {
        return (array)json_decode(@constant(\MollieModuleCenterModule::MOLLIE_DEFAULT_STATUSES), true);
    }

    /**
     * @param string $apiKey
     */
    public function setLiveKey($apiKey)
    {
        $this->saveConfigValue('liveApiKey', $apiKey);
    }

    /**
     * @return string|null
     */
    public function getLiveApiKey()
    {
        return $this->getConfigValue('liveApiKey');
    }

    /**
     * @param string $apiKey
     */
    public function setTestKey($apiKey)
    {
        $this->saveConfigValue('liveTestKey', $apiKey);
    }

    /**
     * @return string
     */
    public function getTestApiKey()
    {
        return $this->getConfigValue('liveTestKey');
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getExtensionVersionCheckUrl()
    {
        return static::VERSION_CHECK_URL;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function getExtensionDownloadUrl($latestVersion = null)
    {
        return $latestVersion ? static::PLUGIN_DOWNLOAD_URL . "/tag/v$latestVersion" : static::PLUGIN_DOWNLOAD_URL;
    }
}
