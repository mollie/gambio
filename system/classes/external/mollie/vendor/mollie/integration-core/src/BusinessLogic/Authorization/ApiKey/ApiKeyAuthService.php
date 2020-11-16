<?php

namespace Mollie\BusinessLogic\Authorization\ApiKey;

use Mollie\BusinessLogic\Authorization\AuthorizationService;
use Mollie\BusinessLogic\Authorization\Interfaces\TokenInterface;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;

/**
 * Class AuthorizationService
 *
 * @package Mollie\BusinessLogic\Authorization\ApiKey
 */
class ApiKeyAuthService extends AuthorizationService
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
     * @param TokenInterface $token
     *
     * @throws HttpAuthenticationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function connect(TokenInterface $token)
    {
        parent::connect($token);
        $this->configService->setWebsiteProfile($this->getProxy()->getCurrentProfile());
    }

    /**
     * Attempts to connect to Mollie API with provided API key.
     *
     * @param TokenInterface $token
     *
     * @return bool
     */
    public function validateToken(TokenInterface $token)
    {
        $configService = $this->getConfigService();
        $proxy = $this->getProxy();

        return $configService->doWithContext(
            'token_verification',
            function () use($token, $configService, $proxy) {
                $configService->setAuthorizationToken($token->getToken());
                $configService->setTestMode($token->isTest());

                try {
                    $proxy->getCurrentProfile();
                    $result = true;
                } catch (\Exception $e) {
                    $result = false;
                }

                $configService->removeConfigValue('authToken');
                $configService->removeConfigValue('testMode');

                return $result;
            }
        );
    }
}
