<?php

namespace Mollie\BusinessLogic\WebHook;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\Payments\PaymentService;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\EventBus;

/**
 * Class WebHookTransformer
 *
 * @package Mollie\BusinessLogic\WebHook
 */
class WebHookTransformer extends BaseService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * @param $rawRequest
     *
     * @throws HttpCommunicationException
     */
    public function handle($rawRequest)
    {
        Logger::logDebug('Web hook detected', 'Core', array('payload' => $rawRequest));

        WebHookContext::start();
        $this->doHandle($rawRequest);
        WebHookContext::stop();
    }

    /**
     * @param OrderReference $orderReference
     *
     * @return OrderChangedWebHookEvent|PaymentChangedWebHookEvent|null
     *
     * @throws HttpCommunicationException
     */
    protected function fireChangeEvent(OrderReference $orderReference)
    {
        /** @var EventBus $eventBuss */
        $eventBuss = ServiceRegister::getService(EventBus::CLASS_NAME);
        $changeEvent = null;

        try {
            $changeEvent = $this->getChangeEvent($orderReference);
            $eventBuss->fire($changeEvent);
        } catch (ReferenceNotFoundException $e) {
            Logger::logError('Failed to create web hook event from payload because order reference does not exist.');
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.webhook.notification.invalid_shop_order.title'),
                new NotificationText('mollie.payment.webhook.notification.invalid_shop_order.description'),
                $orderReference->getShopReference()
            );
            // Do not rethrow to avoid information leaking to malicious third parties
        } catch (HttpAuthenticationException $e) {
            Logger::logError('Failed to create web hook event from payload because authentication to mollie API failed.');
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.webhook.notification.invalid_credentials.title'),
                new NotificationText('mollie.payment.webhook.notification.invalid_credentials.description'),
                $orderReference->getShopReference()
            );
            // Do not rethrow to avoid information leaking to malicious third parties
        } catch (UnprocessableEntityRequestException $e) {
            Logger::logError(
                'Failed to create web hook event from payload.',
                'Core',
                array(
                    'ExceptionMessage' => $e->getMessage(),
                    'ExceptionTrace' => $e->getTraceAsString(),
                )
            );
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.webhook.notification.invalid_api_order.title'),
                new NotificationText(
                    'mollie.payment.webhook.notification.invalid_api_order.description',
                    array('api_message' => $e->getMessage())
                ),
                $orderReference->getShopReference()
            );
            // Do not rethrow to avoid information leaking to malicious third parties
        } catch (HttpRequestException $e) {
            Logger::logError(
                'Failed to create web hook event from payload.',
                'Core',
                array(
                    'ExceptionMessage' => $e->getMessage(),
                    'ExceptionTrace' => $e->getTraceAsString(),
                )
            );
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.webhook.notification.invalid_api_order.title'),
                new NotificationText(
                    'mollie.payment.webhook.notification.invalid_api_order.description',
                    array('api_message' => $e->getMessage())
                ),
                $orderReference->getShopReference()
            );
            // Do not rethrow to avoid information leaking to malicious third parties
        } catch (HttpCommunicationException $e) {
            Logger::logError(
                'Failed to create web hook event from payload because off network connection problems.',
                'Core',
                array(
                    'ExceptionMessage' => $e->getMessage(),
                    'ExceptionTrace' => $e->getTraceAsString(),
                )
            );
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.webhook.notification.network_communication_problem.title'),
                new NotificationText(
                    'mollie.payment.webhook.notification.network_communication_problem.description',
                    array('technical_message' => $e->getMessage())
                ),
                $orderReference->getShopReference()
            );

            // Rethrow to signal mollie api to resend web hook for a retry
            throw $e;
        }

        return $changeEvent;
    }

    /**
     * @param $rawRequest
     *
     * @throws HttpCommunicationException
     */
    protected function doHandle($rawRequest)
    {
        $request = array();
        parse_str($rawRequest, $request);

        // Fire order web hook event for order payment web hooks
        $request['id'] = $this->determineRequestId($request['id']);

        $orderReference = $this->getOrderReferenceData($request['id']);
        if (!$orderReference) {
            WebHookContext::stop();
            return;
        }

        $changeEvent = $this->fireChangeEvent($orderReference);
        if ($changeEvent) {
            $this->updateOrderReference($changeEvent);
        }
    }

    /**
     * @param $id
     *
     * @return string
     */
    protected function determineRequestId($id)
    {
        if (strpos($id, 'ord') === 0) {
            return $id;
        }

        $payment = $this->tryGetPayment($id);
        if ($payment && $payment->getOrderId()) {
            $id = $payment->getOrderId();
        }

        return $id;
    }

    /**
     * @param string $id
     *
     * @return Payment|null
     */
    protected function tryGetPayment($id)
    {
        try {
            $payment = $this->getProxy()->getPayment($id);
        } catch (\Exception $e) {
            $payment = null;
        }

        return $payment;
    }

    /**
     * @param string $mollieReference Payment or order id
     *
     * @return OrderReference|null
     */
    protected function getOrderReferenceData($mollieReference)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        return $orderReferenceService->getByMollieReference($mollieReference);
    }

    /**
     * @param OrderChangedWebHookEvent|PaymentChangedWebHookEvent $changeEvent
     */
    protected function updateOrderReference($changeEvent)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        $orderReferenceService->updateOrderReference(
            $this->getNewOrderReferencePayload($changeEvent),
            $changeEvent->getOrderReference()->getShopReference(),
            $changeEvent->getOrderReference()->getApiMethod()
        );
    }

    /**
     * @param OrderReference $orderReference
     *
     * @return OrderChangedWebHookEvent|PaymentChangedWebHookEvent
     *
     * @throws UnprocessableEntityRequestException
     * @throws ReferenceNotFoundException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    protected function getChangeEvent(OrderReference $orderReference)
    {
        if ($orderReference->getApiMethod() === PaymentMethodConfig::API_METHOD_PAYMENT) {
            /** @var PaymentService $service */
            $service = ServiceRegister::getService(PaymentService::CLASS_NAME);
            return new PaymentChangedWebHookEvent(
                $orderReference,
                $service->getPayment($orderReference->getShopReference())
            );
        }

        /** @var OrderService $service */
        $service = ServiceRegister::getService(OrderService::CLASS_NAME);
        return new OrderChangedWebHookEvent(
            $orderReference,
            $service->getOrder($orderReference->getShopReference())
        );
    }

    /**
     * @param OrderChangedWebHookEvent|PaymentChangedWebHookEvent $changeEvent
     *
     * @return Payment|Order
     */
    protected function getNewOrderReferencePayload($changeEvent)
    {
        if ($changeEvent instanceof PaymentChangedWebHookEvent) {
            return $changeEvent->getNewPayment();
        }

        return $changeEvent->getNewOrder();
    }
}
