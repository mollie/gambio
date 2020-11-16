<?php

use Mollie\BusinessLogic\WebHook\WebHookContext;
use Mollie\BusinessLogic\WebHook\WebHookTransformer;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\ServiceRegister;

include_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/autoload.php';

/**
 * Class MollieWebhookController
 */
class MollieWebhookController extends HttpViewController
{
    /**
     * @var WebHookTransformer
     */
    private $webhookTransformer;

    /**
     * Handles webhook action
     *
     * @return JsonHttpControllerResponse
     * @throws HttpCommunicationException
     */
    public function actionDefault()
    {
        WebHookContext::start();
        $rawRequest = file_get_contents('php://input');
        $this->_getWebhookTransformer()->handle($rawRequest);
        WebHookContext::stop();

        return MainFactory::create(
            'JsonHttpControllerResponse',
            ['success' => true]
        );
    }

    /**
     * @return WebHookTransformer
     */
    protected function _getWebhookTransformer()
    {
        if ($this->webhookTransformer === null) {
            $this->webhookTransformer = ServiceRegister::getService(WebHookTransformer::CLASS_NAME);
        }

        return $this->webhookTransformer;
    }
}
