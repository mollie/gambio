<?php

namespace Mollie\BusinessLogic\Connect;

use Mollie\BusinessLogic\Connect\DTO\AuthInfo;
use Mollie\BusinessLogic\Connect\DTO\TokenRequest;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;

/**
 * Class TokenService
 * @package Mollie\BusinessLogic\Connect
 */
class TokenService
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;

    const AUTH_CODE = 'authorization_code';
    const REFRESH_TOKEN = 'refresh_token';

    /**
     * @var TokenProxy $tokenProxy
     */
    private $tokenProxy;

    /**
     * TokenService constructor.
     * @param TokenProxy $tokenProxy
     */
    public function __construct($tokenProxy)
    {
        $this->tokenProxy = $tokenProxy;
    }

    /**
     * Gets AuthInfo based on given code
     *
     * @param $authCode
     * @param string $redirectUrl
     * @param string $clientId
     * @param string $clinetSecret
     *
     * @return AuthInfo
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function generate($authCode, $redirectUrl = '', $clientId = '', $clinetSecret = '')
    {
        $tokenRequest = new TokenRequest(static::AUTH_CODE, $authCode, '', $redirectUrl);

        return $this->tokenProxy->retrieveTokens($tokenRequest, $clientId, $clinetSecret);
    }

    /**
     * Gets AuthInfo based on given refresh token
     *
     * @param $refreshToken
     * @param string $redirectUrl
     * @param string $clientId
     * @param string $clinetSecret
     * @return AuthInfo
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function refreshToken($refreshToken, $redirectUrl = '', $clientId = '', $clinetSecret = '')
    {
        $tokenRequest = new TokenRequest(static::REFRESH_TOKEN, '', $refreshToken, $redirectUrl);

        return $this->tokenProxy->retrieveTokens($tokenRequest, $clientId, $clinetSecret);
    }
}
