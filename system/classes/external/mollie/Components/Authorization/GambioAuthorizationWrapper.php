<?php


namespace Mollie\Gambio\Authorization;

use Mollie\BusinessLogic\Authorization\ApiKey\ApiKey;
use Mollie\BusinessLogic\Authorization\Interfaces\AuthorizationService;
use Mollie\BusinessLogic\Http\DTO\PaymentMethod;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Gambio\Services\Business\PaymentMethodService;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
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
     * @var string
     */
    private $liveKey;
    /**
     * @var string
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
     * @var PaymentMethodService
     */
    private $paymentMethodsService;
    /**
     * @var \messageStack_ORIGIN
     */
    private $messageStack;
    /**
     * @var MollieTranslator
     */
    private $translator;

    /**
     * GambioAuthorizationWrapper constructor.
     *
     * @param string $isTest
     * @param string $liveKey
     * @param string $testKey
     */
    public function __construct($isTest, $liveKey, $testKey)
    {
        $this->isTest                  = $isTest;
        $this->liveKey                 = $liveKey;
        $this->testKey                 = $testKey;
        $this->authService             = ServiceRegister::getService(AuthorizationService::CLASS_NAME);
        $this->paymentMethodsService   = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        $this->configService           = ServiceRegister::getService(Configuration::CLASS_NAME);
        $this->messageStack            = $GLOBALS['messageStack'];
        $this->translator              = new MollieTranslator();
    }

    /**
     * Verifies input tokens
     */
    public function verify()
    {
        if (empty($this->liveKey) && empty($this->testKey)) {
            $this->messageStack->add_session($this->translator->translate('mollie_keys_missing'), 'error');

            return;
        }

        if (!empty($this->liveKey)) {
            try {
                $this->_validateKey($this->liveKey, false);
            } catch (\Exception $exception) {
                $this->_showFailureMessage('Live', $exception->getMessage());
            }
        }

        if (!empty($this->testKey)) {
            try {
                $this->_validateKey($this->testKey, true);
            } catch (\Exception $exception) {
                $this->_showFailureMessage('Test', $exception->getMessage());
            }
        }
    }

    /**
     * Performs connect operation
     */
    public function connect()
    {
        $token = $this->isTest ?
            $this->_createToken($this->testKey, true) : $this->_createToken($this->liveKey, false);

        if (!$token) {
            throw new \InvalidArgumentException('Api key not provided for the selected mode.');
        }

        $this->authService->connect($token);
    }

    /**
     * @param string $key
     * @param bool $isTest
     *
     * @throws HttpAuthenticationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _validateKey($key, $isTest)
    {
        $token = $this->_createToken($key, $isTest);
        if ($token && $this->authService->validateToken($token)) {
            $methodName = $isTest ? 'setTestKey' : 'setLiveKey';
            $this->configService->{$methodName}($token->getToken());
            $this->_showSuccessMessage($token);
        } else {
            throw new HttpAuthenticationException('Authorization failed with the API key');
        }
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

    /**
     * @param ApiKey $key
     *
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _showSuccessMessage(ApiKey $key)
    {
        $enabledMethods = $this->paymentMethodsService->getEnabledPaymentMethodsWithTempAPIKey($key->getToken());
        $messageParams = [
            '{key_type}'        => $key->isTest() ? 'Test' : 'Live',
            '{enabled_methods}' => PaymentMethod::listPaymentMethodsAsString($enabledMethods),
        ];

        $message = $this->translator->translate('mollie_connect_success', $messageParams);
        $this->messageStack->add_session($message, 'success');
    }

    /**
     * @param string $keyType
     * @param string $exceptionMessage
     */
    private function _showFailureMessage($keyType, $exceptionMessage)
    {
        $params = [
            '{key_type}'    => $keyType,
            '{api_message}' => $exceptionMessage,
        ];

        $message = $this->translator->translate('mollie_connect_failure', $params);
        $this->messageStack->add_session($message, 'error');
    }
}
