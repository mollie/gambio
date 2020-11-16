<?php

use Mollie\Gambio\Authorization\GambioAuthorizationWrapper;
use Mollie\Gambio\Utility\MollieTranslator;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

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

        if ($this->_verifyPayload($payload) && $this->_tokensValid($payload)) {
            $messageKey  = 'mollie_connect_success';
            $messageType = 'success';
        } else {
            $messageType = 'error';
            $messageKey  = 'mollie_connect_failure';
        }

        $lang = new MollieTranslator();
        $GLOBALS['messageStack']->add_session($lang->translate($messageKey), $messageType);

        return MainFactory::create('JsonHttpControllerResponse', []);
    }

    /**
     * @param array $payload
     *
     * @return bool
     */
    private function _tokensValid(array $payload)
    {
        try {
            $authWrapper = new GambioAuthorizationWrapper(
                $payload['is_test'],
                $payload['live_token'],
                $payload['test_token']
            );

            return $authWrapper->verify();
        } catch (Exception $exception) {
            return false;
        }
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
