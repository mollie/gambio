<?php

use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\Gambio\APIProcessor\Exceptions\RefundFormNotValidException;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/../../../autoload.php';

/**
 * Class MollieRefundController
 */
class MollieRefundController extends AdminHttpViewController
{
    /**
     * @var Proxy
     */
    private $proxy;

    /**
     * @return AdminLayoutHttpControllerResponse
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function actionDefault()
    {
        $template = PathProvider::getAdminTemplate('refund.html', 'OrderDashboard/Popups');
        $title = new NonEmptyStringType('Mollie Configuration');
        $data = MainFactory::create('KeyValueCollection', $this->_getTemplateData());

        return MainFactory::create('AdminLayoutHttpControllerResponse', $title, $template, $data);
    }

    /**
     * @return JsonHttpControllerResponse
     */
    public function actionProcessRefund()
    {
        $messageKey = 'mollie_refund_success';
        $messageType = 'success';
        $apiMsg = '';
        try {
            $orderId = $this->_getQueryParameter('orders_id');
            $payload = json_decode(file_get_contents('php://input'), true);
            $transactionId = $this->getTransactionId($orderId);

            $refund = $this->_validatePayloadAndCreatePaymentRefund($payload);
            $this->_getProxy()->createPaymentRefund($refund, $transactionId);

        } catch (Exception $exception) {
            $messageKey = 'mollie_refund_error';
            $messageType = 'error';
            $apiMsg = $exception->getMessage();
            Logger::logError(
                'Failed to process refund action',
                'Integration',
                [
                    'ExceptionMessage' => $exception->getMessage(),
                    'ExceptionTrace' => $exception->getTraceAsString(),
                ]
            );
        }

        $languageTextManager = new MollieTranslator();
        $message = $languageTextManager->translate($messageKey) . $apiMsg;
        $GLOBALS['messageStack']->add_session($message, $messageType);

        $data['success'] = true;

        return MainFactory::create('JsonHttpControllerResponse', $data);
    }

    /**
     * @return array
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _getTemplateData()
    {
        $orderId = $this->_getQueryParameter('orders_id');
        $transactionId = $this->getTransactionId($orderId);
        /** @var OrderReadServiceInterface $orderService */
        $orderService = StaticGXCoreLoader::getService('OrderRead');
        /** @var OrderInterface $gambioOrder */
        $gambioOrder = $orderService->getOrderById(new IdType($orderId));

        $data['payment'] = $this->_getPaymentRefund($transactionId);

        $data['currency'] = $gambioOrder->getCurrencyCode()->getCode();
        $data['js_admin'] = UrlProvider::getPluginJavascriptUrl('');
        $data['css_admin'] = UrlProvider::getPluginCssUrl('');
        $data['process_refund_url'] = UrlProvider::generateAdminUrl(
            'admin.php',
            'MollieRefund/processRefund',
            ['orders_id' => $orderId]
        );

        return $data;
    }

    /**
     * @param string $orderId
     *
     * @return string
     */
    private function getTransactionId($orderId)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        $orderReference = $orderReferenceService->getByShopReference($orderId);

        if (strpos($orderReference->getMollieReference(), 'ord_') !== false) {
            $payload = $orderReference->getPayload();
            $payment = $payload['_embedded']['payments'];
            if (count($payment) > 0) {
                $payment = $payment[0];
                return $payment['id'];
            }
        }

        return $orderReference->getMollieReference();
    }

    /**
     * @param string $transactionId
     *
     * @return array
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _getPaymentRefund($transactionId)
    {
        $molliePayment = $this->_getProxy()->getPayment($transactionId);

        $data = $molliePayment->toArray();
        $data['availableForRefund'] = $molliePayment->getAmount()->getAmountValue() - $molliePayment->getAmountRefunded()->getAmountValue();

        return $data;
    }

    /**
     * @param array $payload
     *
     * @return Refund
     * @throws RefundFormNotValidException
     */
    private function _validatePayloadAndCreatePaymentRefund(array $payload)
    {
        if (empty($payload['amount']['value']) || !is_numeric($payload['amount']['value'])) {
            throw new RefundFormNotValidException('Amount to refund needs to be a numeric value');
        }

        if (empty($payload['amount']['currency'])) {
            throw new RefundFormNotValidException('Currency not set');
        }

        return Refund::fromArray($payload);
    }

    /**
     * @return Proxy
     */
    private function _getProxy()
    {
        if ($this->proxy === null) {
            $this->proxy = ServiceRegister::getService(Proxy::CLASS_NAME);
        }

        return $this->proxy;
    }
}