<?php

use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\Payments\PaymentService;
use Mollie\BusinessLogic\Refunds\RefundService;
use Mollie\Gambio\APIProcessor\Exceptions\RefundFormNotValidException;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/../../../autoload.php';

/**
 * Class MollieRefundController
 */
class MollieRefundController extends AdminHttpViewController
{

    /**
     * @var OrderReferenceService
     */
    private $orderReferenceService;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var RefundService
     */
    private $refundService;
    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * @return HttpControllerResponseInterface|mixed
     */
    public function actionDefault()
    {
        $template = PathProvider::getAdminTemplate('refund.html', 'OrderDashboard/Popups');
        $title    = new NonEmptyStringType('Mollie Configuration');
        $data     = MainFactory::create('KeyValueCollection', $this->_getTemplateData());

        return MainFactory::create('AdminLayoutHttpControllerResponse', $title, $template, $data);
    }

    /**
     * @return JsonHttpControllerResponse
     */
    public function actionProcessRefund()
    {
        $messageKey  = 'mollie_refund_success';
        $messageType = 'success';
        $apiMsg      = '';
        try {
            $orderId = $this->_getQueryParameter('orders_id');
            $payload = json_decode(file_get_contents('php://input'), true);
            if ($payload['ordersApiUsed']) {
                $refund = $this->_validatePayloadAndCreateOrderRefund($payload);
                $this->_getRefundService()->refundOrderLines($orderId, $refund);
            } else {
                $refund = $this->_validatePayloadAndCreatePaymentRefund($payload);
                $isOrdersApiUsed = $this->_isOrdersApiUsed($orderId);
                $refundMethod = $isOrdersApiUsed ? 'refundWholeOrder' : 'refundPayment';
                $this->_getRefundService()->{$refundMethod}($orderId, $refund);
            }
        } catch (Exception $exception) {
            $messageKey  = 'mollie_refund_error';
            $messageType = 'error';
            $apiMsg      = $exception->getMessage();
            Logger::logError(
                'Failed to process refund action',
                'Integration',
                [
                    'ExceptionMessage' => $exception->getMessage(),
                    'ExceptionTrace'   => $exception->getTraceAsString(),
                ]
            );
        }

        $languageTextManager = new MollieTranslator();
        $message             = $languageTextManager->translate($messageKey) . $apiMsg;
        $GLOBALS['messageStack']->add_session($message, $messageType);

        $data['success'] = true;

        return MainFactory::create('JsonHttpControllerResponse', $data);
    }

    /**
     * @return array
     */
    private function _getTemplateData()
    {
        $orderId         = $this->_getQueryParameter('orders_id');
        /** @var OrderReadServiceInterface $orderService */
        $orderService    = StaticGXCoreLoader::getService('OrderRead');
        /** @var OrderInterface $gambioOrder */
        $gambioOrder     = $orderService->getOrderById(new IdType($orderId));

        $isOrdersApiUsed = $this->_isOrdersApiUsed($orderId);

        if ($isOrdersApiUsed) {
            $data['order'] = $this->_getOrderData($orderId);
        } else {
            $data['payment'] = $this->_getPaymentRefund($orderId);
        }

        $data['currency']           = $gambioOrder->getCurrencyCode()->getCode();
        $data['is_orders_api']      = $isOrdersApiUsed;
        $data['process_refund_url'] = UrlProvider::generateAdminUrl(
            'admin.php',
            'MollieRefund/processRefund',
            ['orders_id' => $orderId]
        );

        return $data;
    }

    /**
     * @param $orderId
     *
     * @return array
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _getOrderData($orderId)
    {
        $mollieOrder = $this->_getOrderService()->getOrder($orderId);

        $data                       = $mollieOrder->toArray();
        $data['availableForRefund'] = $mollieOrder->getAmount()->getAmountValue() - $mollieOrder->getAmountRefunded()->getAmountValue();

        return $data;
    }

    /**
     * @param int $orderId
     *
     * @return array
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _getPaymentRefund($orderId)
    {
        $molliePayment = $this->_getPaymentService()->getPayment($orderId);

        $data                       = $molliePayment->toArray();
        $data['availableForRefund'] = $molliePayment->getAmount()->getAmountValue() - $molliePayment->getAmountRefunded()->getAmountValue();

        return $data;
    }

    /**
     * @return OrderReferenceService
     */
    private function _getOrderReferenceService()
    {
        if ($this->orderReferenceService === null) {
            $this->orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        }

        return $this->orderReferenceService;
    }

    /**
     * @return OrderService
     */
    private function _getOrderService()
    {
        if ($this->orderService === null) {
            $this->orderService = ServiceRegister::getService(OrderService::CLASS_NAME);
        }

        return $this->orderService;
    }

    /**
     * @return RefundService
     */
    private function _getRefundService()
    {
        if ($this->refundService === null) {
            $this->refundService = ServiceRegister::getService(RefundService::CLASS_NAME);
        }

        return $this->refundService;
    }

    /**
     * @return PaymentService
     */
    private function _getPaymentService()
    {
        if ($this->paymentService === null) {
            $this->paymentService = ServiceRegister::getService(PaymentService::CLASS_NAME);
        }

        return $this->paymentService;
    }

    /**
     * @param array $payload
     *
     * @return Refund
     * @throws RefundFormNotValidException
     */
    private function _validatePayloadAndCreateOrderRefund(array $payload)
    {
        if (empty($payload['lines'])) {
            throw new RefundFormNotValidException('Order lines not set in the payload');
        }

        return Refund::fromArray($payload);
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
     * @param int $orderId
     *
     * @return bool
     */
    private function _isOrdersApiUsed($orderId)
    {
        return $this->_getOrderReferenceService()->getApiMethod($orderId) === PaymentMethodConfig::API_METHOD_ORDERS;
    }
}