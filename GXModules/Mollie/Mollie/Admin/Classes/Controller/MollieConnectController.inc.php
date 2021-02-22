<?php

use Mollie\Gambio\Authorization\GambioAuthorizationWrapper;

require_once __DIR__ . '/../../../autoload.php';

/**
 * Class MollieConnectVerify
 */
class MollieConnectController extends AdminHttpViewController
{
    /**
     * @return HttpControllerResponseInterface|mixed
     */
    public function actionDefault()
    {
        $payload     = json_decode(file_get_contents('php://input'), true);

        if ($this->_verifyPayload($payload)) {
            $this->_validateTokens($payload);
        }

        return MainFactory::create('JsonHttpControllerResponse', []);
    }

    /**
     * @param array $payload
     */
    private function _validateTokens(array $payload)
    {
        $authWrapper = new GambioAuthorizationWrapper(
            $payload['is_test'],
            $payload['live_token'],
            $payload['test_token']
        );

        $authWrapper->verify();
    }

    /**
     * @param array $payload
     *
     * @return bool
     */
    private function _verifyPayload($payload)
    {
        return array_key_exists('is_test', $payload) &&
            array_key_exists('live_token', $payload) &&
            array_key_exists('test_token', $payload);

    }
}
