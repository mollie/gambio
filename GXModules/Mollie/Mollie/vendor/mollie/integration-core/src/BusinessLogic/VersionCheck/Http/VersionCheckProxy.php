<?php

namespace Mollie\BusinessLogic\VersionCheck\Http;

use Mollie\BusinessLogic\Http\Proxy;

/**
 * Class VersionCheckProxy
 *
 * @package Mollie\BusinessLogic\VersionCheck\Http
 */
class VersionCheckProxy extends Proxy
{
    const CLASS_NAME = __CLASS__;

    /**
     * Returns latest published plugin version
     *
     * @param string $versionCheckUrl
     *
     * @return string|null
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function getLatestPluginVersion($versionCheckUrl)
    {
        $response = $this->call(self::HTTP_METHOD_GET, $versionCheckUrl);
        $result = $response->decodeBodyAsJson();

        return array_key_exists('version', $result) ? $result['version'] : null;
    }

    /**
     * @inheritDoc
     * @param string $method
     * @param string $endpoint
     *
     * @return string
     */
    protected function getRequestUrl($method, $endpoint)
    {
        return $endpoint;
    }

    /**
     * @inheritDoc
     * @return array|string[]
     */
    protected function getRequestHeaders()
    {
        $headers = parent::getRequestHeaders();
        unset($headers['token']);

        return $headers;
    }
}
