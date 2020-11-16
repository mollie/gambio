<?php

namespace Mollie\Infrastructure\Http;

use Mollie\Infrastructure\Http\DTO\OptionsDTO;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;

/**
 * Class HttpClient.
 *
 * @package Mollie\Infrastructure\Http
 */
abstract class HttpClient
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Create, log and send request.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     *
     * @return HttpResponse Response from making HTTP request.
     *
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     */
    public function request($method, $url, $headers = array(), $body = '')
    {
        return $this->sendHttpRequest($method, $url, $headers, $body);
    }

    /**
     * Create, log and send request asynchronously.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     *
     */
    public function requestAsync($method, $url, $headers = array(), $body = '')
    {
        $this->sendHttpRequestAsync($method, $url, $headers, $body);
    }

    /**
     * Auto configures http call options. Tries to make a request to the provided URL with all configured
     * configurations of HTTP options. When first succeeds, stored options should be used.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     *
     * @return bool TRUE if configuration went successfully; otherwise, FALSE.
     */
    public function autoConfigure($method, $url, $headers = array(), $body = '')
    {
        $passed = $this->isRequestSuccessful($method, $url, $headers, $body);
        if ($passed) {
            return true;
        }

        $combinations = $this->getAdditionalOptionsCombinations();
        foreach ($combinations as $combination) {
            $this->setAdditionalOptions($combination);
            $passed = $this->isRequestSuccessful($method, $url, $headers, $body);
            if ($passed) {
                return true;
            }

            $this->resetAdditionalOptions();
        }

        return false;
    }

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
    abstract protected function sendHttpRequest($method, $url, $headers = array(), $body = '');

    /**
     * Create and send request asynchronously.
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     */
    abstract protected function sendHttpRequestAsync($method, $url, $headers = array(), $body = '');

    /**
     * Get additional options combinations for request.
     *
     * @return array
     *  Array of additional options combinations. Each array item should be an array of OptionsDTO instance.
     */
    protected function getAdditionalOptionsCombinations()
    {
        // Left blank intentionally so integrations can override this method,
        // in order to return all possible combinations for additional curl options
        return array();
    }

    /**
     * Save additional options for request.
     *
     * @param OptionsDTO[] $options Additional option to add to HTTP request.
     */
    protected function setAdditionalOptions($options)
    {
        // Left blank intentionally so integrations can override this method,
        // in order to save combination to some persisted array which HttpClient can use it later while creating request
    }

    /**
     * Reset additional options for request to default value.
     */
    protected function resetAdditionalOptions()
    {
        // Left blank intentionally so integrations can override this method,
        // in order to reset to its default values persisted array which `HttpClient` uses later while creating request
    }

    /**
     * Verifies the response and returns TRUE if valid, FALSE otherwise
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE etc.)
     * @param string $url Request URL. Full URL where request should be sent.
     * @param array|null $headers Request headers to send. Key as header name and value as header content. Optional.
     * @param string $body Request payload. String data to send as HTTP request payload. Optional.
     *
     * @return bool TRUE if request was successful; otherwise, FALSE.
     */
    private function isRequestSuccessful($method, $url, $headers = array(), $body = '')
    {
        try {
            /** @var HttpResponse $response */
            $response = $this->request($method, $url, $headers, $body);
        } catch (HttpCommunicationException $ex) {
            $response = null;
        }

        return $response !== null && $response->isSuccessful();
    }
}
