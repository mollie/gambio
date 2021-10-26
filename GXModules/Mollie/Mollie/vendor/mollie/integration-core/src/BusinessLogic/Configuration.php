<?php

namespace Mollie\BusinessLogic;

use Mollie\BusinessLogic\Connect\DTO\AuthInfo;
use Mollie\BusinessLogic\Http\DTO\WebsiteProfile;
use Mollie\Infrastructure\Logger\Logger;

/**
 * Class Configuration
 *
 * @package Mollie\BusinessLogic
 */
abstract class Configuration extends \Mollie\Infrastructure\Configuration\Configuration
{

    const MIN_LOG_LEVEL = Logger::INFO;

    /**
     * Retrieves integration (shop system) version.
     *
     * @return string Integration version.
     */
    abstract public function getIntegrationVersion();

    /**
     * Retrieves extension (plugin) name (for example MollieMagento2).
     *
     * @return string Extension name.
     */
    abstract public function getExtensionName();

    /**
     * Retrieves extension (plugin) version.
     *
     * @return string Extension version.
     */
    abstract public function getExtensionVersion();

    /**
     * Returns URL for checking extension version
     *
     * @return string URL for checking extension version
     */
    abstract public function getExtensionVersionCheckUrl();

    /**
     * Returns URL for downloading plugin
     *
     * @param string|null $latestVersion
     *
     * @return string URL for downloading plugin
     */
    abstract public function getExtensionDownloadUrl($latestVersion = null);

    /**
     * Removes configuration entity with provided name.
     *
     * @param string $name Configuration property name.
     *
     * @return bool TRUE if operation succeeded; otherwise, FALSE.
     */
    public function removeConfigValue($name)
    {
        $entity = $this->getConfigEntity($name);

        return $entity ? $this->getRepository()->delete($entity) : true;
    }

    /**
     * Returns authorization token.
     *
     * @return AuthInfo|null Authorization token if found; otherwise, NULL.
     */
    public function getAuthorizationInfo()
    {
        $authInfo = json_decode($this->getConfigValue('authToken'), true);
        if (empty($authInfo)) {
            return null;
        }

        return AuthInfo::fromArray($authInfo);

    }

    /**
     * Sets authorization token.
     *
     * @param AuthInfo $authInfo Authorization token.
     */
    public function setAuthorizationInfo($authInfo)
    {
        $this->saveConfigValue('authToken', json_encode($authInfo->toArray()));
    }

    /**
     * Returns authorization token.
     *
     * @return string|null Authorization token if found; otherwise, NULL.
     */
    public function getAuthorizationToken()
    {
        return $this->getConfigValue('authToken') ?: null;
    }

    /**
     * Sets authorization token.
     *
     * @param AuthInfo $authToken Authorization token.
     */
    public function setAuthorizationToken($authToken)
    {
        $this->saveConfigValue('authToken', $authToken);
    }

    /**
     * Returns state string.
     *
     * @return string|null State string if found; otherwise, NULL.
     */
    public function getStateString()
    {
        return $this->getConfigValue('state') ?: null;
    }

    /**
     * Sets authorization token.
     *
     * @param string $state State string.
     */
    public function setStateString($state)
    {
        $this->saveConfigValue('state', $state);
    }

    /**
     * Gets test mode
     *
     * @return bool True if test mode is on; false otherwise
     */
    public function isTestMode()
    {
        return (bool)$this->getConfigValue('testMode');
    }

    /**
     * Sets test mode.
     *
     * @param bool $testMode Test mode flag.
     */
    public function setTestMode($testMode)
    {
        $this->saveConfigValue('testMode', (bool)$testMode);
    }

    /**
     * Returns selected website profile data.
     *
     * @return WebsiteProfile|null Website profile id if found; otherwise, NULL.
     */
    public function getWebsiteProfile()
    {
        $websiteProfileData = json_decode($this->getConfigValue('websiteProfile'), true);
        if (empty($websiteProfileData)) {
            return null;
        }

        return WebsiteProfile::fromArray($websiteProfileData);
    }

    /**
     * Sets selected website profile data.
     *
     * @param WebsiteProfile $websiteProfile Website profile.
     */
    public function setWebsiteProfile(WebsiteProfile $websiteProfile = null)
    {
        $this->saveConfigValue('websiteProfile', $websiteProfile ? json_encode($websiteProfile->toArray()) : null);
    }
}
