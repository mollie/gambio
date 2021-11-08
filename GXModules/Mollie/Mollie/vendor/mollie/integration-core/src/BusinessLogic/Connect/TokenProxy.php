<?php

namespace Mollie\BusinessLogic\Connect;

use Mollie\BusinessLogic\Connect\DTO\AuthInfo;
use Mollie\BusinessLogic\Connect\DTO\TokenRequest;
use Mollie\BusinessLogic\Http\BaseProxy;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\Http\HttpResponse;

/**
 * Class TokenProxy
 * @package Mollie\BusinessLogic\Connect
 */
class TokenProxy extends BaseProxy
{
    const TOKEN_URL = 'https://api.mollie.com/oauth2/tokens';

    /**
     * Request Auth info (access token, refresh token)
     *
     * @param TokenRequest $request
     * @param string $clientId
     * @param string $clientSecret
     * @return AuthInfo
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function retrieveTokens(TokenRequest $request, $clientId, $clientSecret)
    {
        $response = $this->call(self::HTTP_METHOD_POST, '', $request->toArray(), $clientId, $clientSecret);
        $body = json_decode($response->getBody(), true);
        $body['expires_in'] = $this->getExpiresInTime($body['expires_in']);

        return AuthInfo::fromArray($body);
    }

    /**
     * Revoke given token
     *
     * @param string $type Type of token (access_token or refresh_token)
     * @param string $token
     *
     * @return void
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function revokeToken($type, $token)
    {
        $body = array(
            'token_type_hint' => $type,
            'token' => $token,
        );

        $this->call(self::HTTP_METHOD_DELETE, '', $body);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $body
     * @param string $clientId
     * @param string $clientSecret
     * @return HttpResponse
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function call($method, $endpoint, array $body = array(), $clientId = '', $clientSecret = '')
    {
        if ($this->configService->isTestMode()) {
            $queryParams['testmode'] = 'true';
        }

        $url = static::TOKEN_URL . '?' . http_build_query($body);
        $response = $this->client->request(
            self::HTTP_METHOD_POST,
            $url,
            $this->getHeaders($clientId, $clientSecret),
            $body
        );

        $this->validateResponse($response);

        return $response;
    }

    /**
     * @param integer $expiresIn
     */
    private function getExpiresInTime($expiresIn)
    {
        $now = new \DateTime('now');
        $expiresIn -= 60;
        $now = $now->modify("+ $expiresIn seconds");

        return $now->getTimestamp();
    }

    /**
     * Returns header
     */
    private function getHeaders($clientId, $clientSecret)
    {
        return array('Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret));
    }
}
