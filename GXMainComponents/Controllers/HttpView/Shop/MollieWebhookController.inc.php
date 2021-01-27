<?php

use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\OrderReference\Exceptions\MollieReferenceNotFoundException;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\WebHook\WebHookContext;
use Mollie\BusinessLogic\WebHook\WebHookTransformer;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

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
        $orderReference = $orderReferenceService->getByMollieReference($_POST['id']);

        if (!$orderReference) {
            $orderReference = $this->_getOrderReferenceFromPayment($orderReferenceService);
            if (!$orderReference) {
                throw new MollieReferenceNotFoundException('Mollie reference not found:' . $_POST['id']);
            }
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

    /**
     * @param OrderReferenceService $orderReferenceService
     *
     * @return OrderReference|null
     */
    protected function _getOrderReferenceFromPayment(OrderReferenceService $orderReferenceService)
    {
        /** @var Proxy $proxy */
        $proxy = ServiceRegister::getService(Proxy::CLASS_NAME);
        try {
            $payment = $proxy->getPayment($_POST['id']);
            if ($payment && $mollieId = $payment->getOrderId()) {
                return $orderReferenceService->getByMollieReference($mollieId);
            }
        } catch (\Exception $e) {
        }

        return null;
    }
}
