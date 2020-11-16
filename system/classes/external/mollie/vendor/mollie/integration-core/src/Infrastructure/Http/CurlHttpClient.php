<?php

namespace Mollie\Infrastructure\Http;

use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Logger\Logger;

/**
 * Class CurlHttpClientService. In charge of doing a HTTP request by using cURL library.
 *
 * @package Mollie\Infrastructure\Http
 */
class CurlHttpClient extends HttpClient
{
    /**
     * Default asynchronous request timeout value.
     */
    const DEFAULT_ASYNC_REQUEST_TIMEOUT = 1000;
    /**
     * cURL handler.
     *
     * @var resource
     */
    private $curlSession;

    /**
     * Create and send request.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     *
     * @return HttpResponse Response object.
     *
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     *      Only in situation when there is no connection or no response.
     */
    protected function sendHttpRequest($method, $url, $headers = array(), $body = '')
    {
        $this->setCurlSessionAndCommonRequestParts($method, $url, $headers, $body);
        $this->setCurlSessionOptionsForSynchronousRequest();

        return $this->executeAndReturnResponseForSynchronousRequest($url);
    }

    /**
     * Create and send request asynchronously.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     *
     * @return bool|string
     */
    protected function sendHttpRequestAsync($method, $url, $headers = array(), $body = '')
    {
        $this->setCurlSessionAndCommonRequestParts($method, $url, $headers, $body);
        $this->setCurlSessionOptionsForAsynchronousRequest();

        $result = curl_exec($this->curlSession);
        $statusCode = curl_getinfo($this->curlSession, CURLINFO_HTTP_CODE);

        if (!in_array($statusCode, array(0, 200), true)) {
            $curlError = '';
            if (curl_errno($this->curlSession)) {
                $curlError = ' cURL error: ' . curl_errno($this->curlSession) . ' => ' . curl_error($this->curlSession);
            }

            $httpError = $statusCode . ' Message: ' . $result . $curlError;
            Logger::logError('Async process failed. ERROR: ' . $httpError);
        }

        curl_close($this->curlSession);

        return $result;
    }

    /**
     * Executes and returns response for synchronous request.
     *
     * @param string $url Request URL.
     *
     * @return HttpResponse
     *
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     */
    protected function executeAndReturnResponseForSynchronousRequest($url)
    {
        $apiResponse = curl_exec($this->curlSession);
        $statusCode = curl_getinfo($this->curlSession, CURLINFO_HTTP_CODE);

        if ($apiResponse === false) {
            $error = curl_errno($this->curlSession) . ' => ' . curl_error($this->curlSession);
            curl_close($this->curlSession);

            throw new HttpCommunicationException('Request ' . $url . ' failed. ERROR: ' . $error);
        }

        curl_close($this->curlSession);
        $apiResponse = $this->strip100Header($apiResponse);

        return new HttpResponse(
            $statusCode,
            $this->getHeadersFromCurlResponse($apiResponse),
            $this->getBodyFromCurlResponse($apiResponse)
        );
    }

    /**
     * Strips 100 header that is added before regular header in certain requests.
     *
     * @param string $response API response.
     *
     * @return string Returns refined response.
     */
    protected function strip100Header($response)
    {
        $delimiter = "\r\n\r\n";
        $needle = 'HTTP/1.1 100';
        if (strpos($response, $needle) === 0) {
            return substr($response, strpos($response, $delimiter) + 4);
        }

        return $response;
    }

    /**
     * Sets cURL session and common request parts.
     *
     * @param string $method Request method.
     * @param string $url Request URL.
     * @param array $headers Array of request headers.
     * @param string $body Request body.
     */
    protected function setCurlSessionAndCommonRequestParts($method, $url, array $headers, $body)
    {
        $this->initializeCurlSession();
        $this->setCurlSessionOptionsBasedOnMethod($method);
        $this->setCurlSessionUrlHeadersAndBody($method, $url, $headers, $body);
        $this->setCommonOptionsForCurlSession($headers);
    }

    /**
     * Initializes cURL session.
     */
    protected function initializeCurlSession()
    {
        $this->curlSession = curl_init();
    }

    /**
     * Sets cURL session option based on request method.
     *
     * @param string $method Request method.
     */
    protected function setCurlSessionOptionsBasedOnMethod($method)
    {
        if ($method === 'DELETE') {
            curl_setopt($this->curlSession, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        if ($method === 'POST') {
            curl_setopt($this->curlSession, CURLOPT_POST, true);
        }

        if ($method === 'PUT') {
            curl_setopt($this->curlSession, CURLOPT_CUSTOMREQUEST, 'PUT');
        }

        if ($method === 'PATCH') {
            curl_setopt($this->curlSession, CURLOPT_CUSTOMREQUEST, 'PATCH');
        }
    }

    /**
     * Sets cURL session URL, headers, and request body.
     *
     * @param string $method Request method.
     * @param string $url Request URL.
     * @param array $headers Array of request headers.
     * @param string $body Request body.
     */
    protected function setCurlSessionUrlHeadersAndBody($method, $url, array $headers, $body)
    {
        curl_setopt($this->curlSession, CURLOPT_URL, $url);
        curl_setopt($this->curlSession, CURLOPT_HTTPHEADER, $headers);
        if (in_array($method, array('POST', 'PUT', 'PATCH', 'DELETE'))) {
            $body = empty($body) ? '1' : $body;
            curl_setopt($this->curlSession, CURLOPT_POSTFIELDS, $body);
        }
    }

    /**
     * Sets common options for cURL session.
     *
     * @param array $headers
     */
    protected function setCommonOptionsForCurlSession(array $headers)
    {
        curl_setopt($this->curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curlSession, CURLOPT_FOLLOWLOCATION, true);
        /**
         * @noinspection CurlSslServerSpoofingInspection
         * Disabled because some shops cannot establish connection when it is on.
         */
        curl_setopt($this->curlSession, CURLOPT_SSL_VERIFYPEER, false);
        /**
         * @noinspection CurlSslServerSpoofingInspection
         * Disabled because some shops cannot establish connection when it is on.
         */
        curl_setopt($this->curlSession, CURLOPT_SSL_VERIFYHOST, false);
        // Set default user agent, because for some shops if user agent is missing, request will not work.
        $addDefaultUserAgent = true;
        foreach ($headers as $header) {
            if (false !== stripos($header, 'user-agent:')) {
                $addDefaultUserAgent = false;
                break;
            }
        }

        if ($addDefaultUserAgent) {
            curl_setopt(
                $this->curlSession,
                CURLOPT_USERAGENT,
                'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36'
            );
        }
    }

    /**
     * Sets cURL session options for synchronous request.
     */
    protected function setCurlSessionOptionsForSynchronousRequest()
    {
        curl_setopt($this->curlSession, CURLOPT_HEADER, true);
    }

    /**
     * Sets cURL session options for asynchronous request.
     */
    protected function setCurlSessionOptionsForAsynchronousRequest()
    {
        // Always ensure the connection is fresh.
        curl_setopt($this->curlSession, CURLOPT_FRESH_CONNECT, true);
        // Timeout super fast once connected, so it goes into async.
        curl_setopt($this->curlSession, CURLOPT_TIMEOUT_MS, self::DEFAULT_ASYNC_REQUEST_TIMEOUT);

        curl_setopt($this->curlSession, CURLOPT_NOPROGRESS, false);
        curl_setopt($this->curlSession, CURLOPT_PROGRESSFUNCTION, array($this, 'abortAfterAsyncRequestCallback'));
    }

    public function abortAfterAsyncRequestCallback(
        /** @noinspection PhpUnusedParameterInspection */
        $curlResource,
        $downloadTotal,
        $downloadSoFar,
        $uploadTotal,
        $uploadedSoFar
    ) {
        // Continue until whole request is uploaded
        if ($uploadTotal == 0 || ($uploadTotal !== $uploadedSoFar)) {
            return 0;
        }

        // Abort as soon as upload is donne. For async request we do not need to wait for response!
        return 1;
    }

    /**
     * Returns array of headers from cURL response.
     *
     * @param string $response Response string.
     *
     * @return array Array of cURL response headers.
     */
    protected function getHeadersFromCurlResponse($response)
    {
        $headers = array();
        $headersBodyDelimiter = "\r\n\r\n";
        $headerText = substr($response, 0, strpos($response, $headersBodyDelimiter));
        $headersDelimiter = "\r\n";

        foreach (explode($headersDelimiter, $headerText) as $i => $line) {
            if ($i === 0) {
                $headers[] = $line;
            } else {
                list($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    /**
     * Returns body from cURL response.
     *
     * @param string $response Response string.
     *
     * @return string Response body.
     */
    protected function getBodyFromCurlResponse($response)
    {
        $headersBodyDelimiter = "\r\n\r\n";
        $bodyStartingPositionOffset = 4; // number of special signs in delimiter;

        return substr($response, strpos($response, $headersBodyDelimiter) + $bodyStartingPositionOffset);
    }
}
