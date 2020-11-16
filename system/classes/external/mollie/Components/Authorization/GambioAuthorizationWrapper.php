<?php


namespace Mollie\Gambio\Authorization;

use Mollie\BusinessLogic\Authorization\ApiKey\ApiKey;
use Mollie\BusinessLogic\Authorization\Interfaces\AuthorizationService;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class GambioAuthorizationWrapper
 *
 * @package Mollie\Gambio\Authorization
 */
class GambioAuthorizationWrapper
{
    /**
     * @var string
     */
    private $isTest;
    /**
     * @var ApiKey
     */
    private $liveKey;
    /**
     * @var ApiKey
     */
    private $testKey;

    /**
     * @var ConfigurationService
     */
    private $configService;
    /**
     * @var AuthorizationService
     */
    private $authService;

    /**
     * GambioAuthorizationWrapper constructor.
     *
     * @param string $isTest
     * @param string $liveKey
     * @param string $testKey
     */
    public function __construct($isTest, $liveKey, $testKey)
    {
        $this->isTest        = $isTest;
        $this->liveKey       = $this->_createToken($liveKey, false);
        $this->testKey       = $this->_createToken($testKey, true);
        $this->authService   = ServiceRegister::getService(AuthorizationService::CLASS_NAME);
        $this->configService = ServiceRegister::getService(Configuration::CLASS_NAME);
    }

    /**
     * Verifies input tokens
     *
     * @return bool
     */
    public function verify()
    {
        if (!$this->liveKey) {
            $this->configService->setLiveKey('');

            return $this->_verifyTest();
        }

        if (!$this->testKey) {
            $this->configService->setTestKey('');

            return $this->_verifyLive();
        }

        return $this->_verifyLive() && $this->_verifyTest();
    }

    /**
     * Performs connect operation
     */
    public function connect()
    {
        $token = $this->isTest ? $this->testKey : $this->liveKey;
        if (!$token) {
            throw new \InvalidArgumentException('Api key not provided for the selected mode.');
        }

        $this->authService->connect($token);
    }

    /**
     * @return bool
     */
    private function _verifyLive()
    {
        $isValid = false;
        if ($this->liveKey && $isValid = $this->authService->validateToken($this->liveKey)) {
            $this->configService->setLiveKey($this->liveKey->getToken());
        }

        return $isValid;
    }

    /**
     * @return bool
     */
    private function _verifyTest()
    {
        $isValid = false;
        if ($this->testKey && $isValid = $this->authService->validateToken($this->testKey)) {
            $this->configService->setTestKey($this->testKey->getToken());
        }

        return $isValid;
    }

    /**
     * @param string $key
     * @param bool   $isTest
     *
     * @return ApiKey|null
     */
    private function _createToken($key, $isTest)
    {
        if (empty($key)) {
            return null;
        }

        $token = new ApiKey($key);
        if ($token->isTest() !== $isTest) {
            throw new \InvalidArgumentException('Token type not valid');
        }

        return $token;
    }
}
