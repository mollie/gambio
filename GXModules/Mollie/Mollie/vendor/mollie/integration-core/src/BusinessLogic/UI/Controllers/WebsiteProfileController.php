<?php

namespace Mollie\BusinessLogic\UI\Controllers;

use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\Http\DTO\WebsiteProfile;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethodService;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class WebsiteProfileController
 *
 * @package Mollie\BusinessLogic\UI\Controllers
 */
class WebsiteProfileController
{
    protected $websiteProfilesCache = array();

    /**
     * Gets list of available website profiles from current organization
     *
     * @return WebsiteProfile[]
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getAll()
    {
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        $authToken = $configService->getAuthorizationToken();
        if (!$authToken) {
            return array();
        }

        if (!array_key_exists($configService->getAuthorizationToken(), $this->websiteProfilesCache)) {
            /** @var Proxy $proxy */
            $proxy = ServiceRegister::getService(Proxy::CLASS_NAME);
            $this->websiteProfilesCache[$configService->getAuthorizationToken()] = $proxy->getWebsiteProfiles();
        }

        return $this->websiteProfilesCache[$configService->getAuthorizationToken()];
    }

    /**
     * Gets current website profile. If website profile is not saved it will try to get profiles from Mollie API and return
     * first profile from the list of available profiles.
     *
     * @return WebsiteProfile|null Saved profile or first from the list of profiles on Mollie API or
     * null if no profiles ara available
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function getCurrent()
    {
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $savedProfile = $configService->getWebsiteProfile();
        if ($savedProfile) {
            return $savedProfile;
        }

        $allProfiles = $this->getAll();
        return !empty($allProfiles) ? $allProfiles[0] : null;
    }

    /**
     * Saves provided website profile as current profile. To save default profile as current call save without arguments.
     *
     * @param WebsiteProfile|null $websiteProfile Profile to set as current profile
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function save(WebsiteProfile $websiteProfile = null)
    {
        /** @var Configuration $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        $newWebsiteProfile = $websiteProfile ?: $this->getCurrent();
        $configService->setWebsiteProfile($newWebsiteProfile);

        /** @var PaymentMethodService $paymentMethodService */
        $paymentMethodService = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        $paymentMethodService->clearAllOther($newWebsiteProfile ? $newWebsiteProfile->getId() : '');
    }
}
