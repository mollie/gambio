<?php


namespace Mollie\BusinessLogic\Authorization\ApiKey;

use Mollie\BusinessLogic\Authorization\Interfaces\TokenInterface;

/**
 * Class ApiKey
 *
 * @package Mollie\BusinessLogic\Authorization\ApiKey\DTO
 */
class ApiKey implements TokenInterface
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * ApiKey constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $apiKey = trim($apiKey);
        if (!preg_match('/^(live|test)_\w{30,}$/', $apiKey)) {
            throw new \InvalidArgumentException("Invalid API key: '{$apiKey}'. An API key must start with 'test_' or 'live_' and must be at least 30 characters long.");
        }

        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->apiKey;
    }

    /**
     * @return bool
     */
    public function isTest()
    {
        return strpos($this->apiKey, 'test') === 0;
    }
}
