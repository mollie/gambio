<?php


namespace Mollie\BusinessLogic\Http;


use Mollie\BusinessLogic\Authorization\Interfaces\AuthorizationService;
use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\Http\OrgToken\ProxyDataProvider;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\Http\HttpClient;
use Mollie\Infrastructure\Http\HttpResponse;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

abstract class BaseProxy
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Mollie base API URL.
     */
    const BASE_URL = 'https://api.mollie.com/';
    /**
     * Mollie API version
     */
    const API_VERSION = 'v2/';
    /**
     * Unauthorized HTTP status code.
     */
    const HTTP_STATUS_CODE_UNAUTHORIZED = 401;
    /**
     * Unprocessable entity status code
     */
    const HTTP_STATUS_CODE_UNPROCESSABLE = 422;
    /**
     * HTTP GET method
     */
    const HTTP_METHOD_GET = 'GET';
    /**
     * HTTP POST method
     */
    const HTTP_METHOD_POST = 'POST';
    /**
     * HTTP PUT method
     */
    const HTTP_METHOD_PATCH = 'PATCH';
    /**
     * HTTP DELETE method
     */
    const HTTP_METHOD_DELETE = 'DELETE';

    /**
     * HTTP Client.
     *
     * @var HttpClient
     */
    protected $client;
    /**
     * @var Configuration
     */
    protected $configService;
    /**
     * @var ProxyDataProvider
     */
    protected $transformer;

    /**
     * Proxy constructor.
     *
     * @param Configuration $configService Configuration service.
     * @param HttpClient $client System HTTP client.
     * @param ProxyDataProvider $transformer
     */
    public function __construct(Configuration $configService, HttpClient $client, ProxyDataProvider $transformer)
    {
        $this->client = $client;
        $this->configService = $configService;
        $this->transformer = $transformer;
    }

    /**
     * Makes a HTTP call and returns response.
     *
     * @param string $method HTTP method (GET, POST, PUT, etc.).
     * @param string $endpoint Endpoint resource on remote API.
     * @param array $body Request payload body.
     *
     * @return HttpResponse Response from request.
     *
     * @throws HttpAuthenticationException
     * @throws UnprocessableEntityRequestException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function call($method, $endpoint, array $body = array())
    {
        $endpoint = ltrim($endpoint, '/');

        $response = $this->client->request(
            $method,
            $this->getRequestUrl($method, $endpoint),
            $this->getRequestHeaders(),
            $this->getBodyAsString($method, $endpoint, $body)
        );

        $this->validateResponse($response);

        return $response;
    }

    /**
     * Creates full request URL for a given endpoint
     *
     * @param string $method HTTP method (GET, POST, PUT, etc.).
     * @param string $endpoint Endpoint resource on remote API.
     *
     * @return string
     */
    protected function getRequestUrl($method, $endpoint)
    {
        $url = static::BASE_URL . static::API_VERSION . $endpoint;
        $this->transformer->adjustUrl($url, $endpoint, $method);

        return $url;
    }

    /**
     * @param string $method HTTP method (GET, POST, PUT, etc.).
     * @param string $endpoint Endpoint resource on remote API.
     * @param array $body Request payload body.
     *
     * @return false|string
     */
    protected function getBodyAsString($method, $endpoint, array $body = array())
    {
        if (strtoupper($method) === self::HTTP_METHOD_GET) {
            return '';
        }

        $this->transformer->adjustBody($body, $endpoint);

        return empty($body) ? '{}' : json_encode($body);
    }

    /**
     * Validates HTTP response.
     *
     * @param HttpResponse $response HTTP response returned from API call.
     *
     * @throws HttpAuthenticationException
     * @throws UnprocessableEntityRequestException
     * @throws HttpRequestException
     */
    protected function validateResponse(HttpResponse $response)
    {
        if (!$response->isSuccessful()) {
            $httpCode = $response->getStatus();
            $error = $response->decodeBodyAsJson();
            $errorMessage = '';
            if (is_array($error)) {
                if (array_key_exists('title', $error)) {
                    $errorMessage = $error['title'];
                } else if (array_key_exists('error', $error)) {
                    $errorMessage = $error['error'];
                }

                if (array_key_exists('detail', $error)) {
                    $errorMessage .= ": {$error['detail']}";
                }
            }

            Logger::logInfo(
                'Request to Mollie API was not successful.',
                'Core',
                array(
                    'ApiErrorMessage' => $errorMessage
                )
            );

            if ($httpCode === self::HTTP_STATUS_CODE_UNAUTHORIZED) {
                throw new HttpAuthenticationException($errorMessage, $httpCode);
            }

            if ($httpCode === self::HTTP_STATUS_CODE_UNPROCESSABLE) {
                throw new UnprocessableEntityRequestException(array_key_exists('field', $error) ? $error['field'] : '', $errorMessage, $httpCode);
            }

            throw new HttpRequestException($errorMessage, $httpCode);
        }
    }

    /**
     * Returns headers together with authorization entry.
     *
     * @return array Formatted request headers.
     */
    protected function getRequestHeaders()
    {
        $userAgents = array(
            'PHP/' . PHP_VERSION,
            str_replace(
                array(' ', "\t", "\n", "\r"),
                '-',
                $this->configService->getIntegrationName() . '/' . $this->configService->getIntegrationVersion()
            ),
            str_replace(
                array(' ', "\t", "\n", "\r"),
                '-',
                $this->configService->getExtensionName() . '/' . $this->configService->getExtensionVersion()
            ),
        );

        return array(
            'accept' => 'Accept: application/json',
            'content' => 'Content-Type: application/json',
            'useragent' => 'User-Agent: ' . implode(' ', $userAgents),
            'token' => 'Authorization: Bearer ' . $this->getAuthorizationService()->getAuthToken(),
        );
    }

    /**
     *  Returns registered authorization service
     *
     * @return AuthorizationService
     */
    protected function getAuthorizationService()
    {
        return ServiceRegister::getService(AuthorizationService::CLASS_NAME);
    }
}