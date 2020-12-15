<?php

use Mollie\BusinessLogic\OrderReference\Exceptions\MollieReferenceNotFoundException;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\WebHook\WebHookContext;
use Mollie\BusinessLogic\WebHook\WebHookTransformer;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Logger\Logger;
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
        try {
            $success = true;
            $this->_checkOrderReference();
            WebHookContext::start();
            $rawRequest = file_get_contents('php://input');
            $this->_getWebhookTransformer()->handle($rawRequest);
            WebHookContext::stop();

        } catch (Exception $exception) {
            Logger::logError('Cannot process webhook:' . $exception->getMessage());
            $success = false;
            http_response_code(422);
        }

        return MainFactory::create(
            'JsonHttpControllerResponse',
            ['success' => $success]
        );
    }

    protected function _checkOrderReference()
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        if (!$orderReferenceService->getByMollieReference($_POST['id'])) {
            throw new MollieReferenceNotFoundException('Mollie reference not found:' . $_POST['id']);
        }
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
