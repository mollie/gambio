<?php

namespace Mollie\BusinessLogic;

use Mollie\BusinessLogic\CheckoutLink\CheckoutLinkService;
use Mollie\BusinessLogic\Http\OrgToken\ProxyDataProvider;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderBillingAddressChangedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderCanceledEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderClosedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderDeletedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderLineChangedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderShippedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderShippingAddressChangedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderTotalChangedEvent;
use Mollie\BusinessLogic\Notifications\Collections\ShopNotificationChannelCollection;
use Mollie\BusinessLogic\Notifications\DefaultNotificationChannel;
use Mollie\BusinessLogic\Notifications\Interfaces\DefaultNotificationChannelAdapter;
use Mollie\BusinessLogic\Notifications\Interfaces\ShopNotificationChannelAdapter;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderBillingAddressChangedEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderCanceledEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderClosedEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderDeletedEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderLineChangedEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderShippedEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderShippingAddressChangedEventHandler;
use Mollie\BusinessLogic\Orders\IntegrationEventHandler\IntegrationOrderTotalChangedEventHandler;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\BusinessLogic\Orders\WebHookHandler\LineStatusWebHookHandler;
use Mollie\BusinessLogic\Orders\WebHookHandler\StatusWebHookHandler as OrderStatusWebHookHandler;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethodService;
use Mollie\BusinessLogic\Payments\PaymentService;
use Mollie\BusinessLogic\Payments\WebHookHandler\StatusWebHookHandler as PaymentStatusWebHookHandler;
use Mollie\BusinessLogic\Refunds\RefundService;
use Mollie\BusinessLogic\Refunds\WebHookHandler\OrderLineRefundWebHookHandler;
use Mollie\BusinessLogic\Refunds\WebHookHandler\OrderRefundWebHookHandler;
use Mollie\BusinessLogic\Shipments\ShipmentService;
use Mollie\BusinessLogic\VersionCheck\Http\VersionCheckProxy;
use Mollie\BusinessLogic\WebHook\OrderChangedWebHookEvent;
use Mollie\BusinessLogic\WebHook\PaymentChangedWebHookEvent;
use Mollie\BusinessLogic\WebHook\WebHookContext;
use Mollie\BusinessLogic\WebHook\WebHookTransformer;
use Mollie\Infrastructure\Http\HttpClient;
use Mollie\Infrastructure\Http\LoggingHttpClient;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\EventBus;

/**
 * Class BootstrapComponent
 *
 * @package Mollie\BusinessLogic
 */
class BootstrapComponent extends \Mollie\Infrastructure\BootstrapComponent
{
    /**
     * Initializes services and utilities.
     */
    protected static function initServices()
    {
        parent::initServices();

        ServiceRegister::registerService(
            Proxy::CLASS_NAME,
            function () {
                /** @var Configuration $config */
                $config = ServiceRegister::getService(Configuration::CLASS_NAME);
                /** @var HttpClient $client */
                $client = ServiceRegister::getService(HttpClient::CLASS_NAME);
                /** @var ProxyDataProvider $transformer */
                $transformer = ServiceRegister::getService(ProxyDataProvider::CLASS_NAME);

                return new Proxy($config, new LoggingHttpClient($client), $transformer);
            }
        );


        ServiceRegister::registerService(
            VersionCheckProxy::CLASS_NAME,
            function () {
                /** @var Configuration $config */
                $config = ServiceRegister::getService(Configuration::CLASS_NAME);
                /** @var HttpClient $client */
                $client = ServiceRegister::getService(HttpClient::CLASS_NAME);
                /** @var ProxyDataProvider $transformer */
                $transformer = ServiceRegister::getService(ProxyDataProvider::CLASS_NAME);

                return new VersionCheckProxy($config, new LoggingHttpClient($client), $transformer);
            }
        );

        ServiceRegister::registerService(
            ProxyDataProvider::CLASS_NAME,
            function () {
                return new ProxyDataProvider();
            }
        );

        ServiceRegister::registerService(
            PaymentMethodService::CLASS_NAME,
            function () {
                return PaymentMethodService::getInstance();
            }
        );

        ServiceRegister::registerService(
            PaymentService::CLASS_NAME,
            function () {
                return PaymentService::getInstance();
            }
        );

        ServiceRegister::registerService(
            OrderReferenceService::CLASS_NAME,
            function () {
                return OrderReferenceService::getInstance();
            }
        );

        ServiceRegister::registerService(
            OrderService::CLASS_NAME,
            function () {
                return OrderService::getInstance();
            }
        );

        ServiceRegister::registerService(
            ShipmentService::CLASS_NAME,
            function () {
                return ShipmentService::getInstance();
            }
        );

        ServiceRegister::registerService(
            CheckoutLinkService::CLASS_NAME,
            function () {
                return CheckoutLinkService::getInstance();
            }
        );

        ServiceRegister::registerService(
            RefundService::CLASS_NAME,
            function () {
                return RefundService::getInstance();
            }
        );

        ServiceRegister::registerService(
            WebHookTransformer::CLASS_NAME,
            function () {
                return WebHookTransformer::getInstance();
            }
        );

        ServiceRegister::registerService(
            ShopNotificationChannelAdapter::CLASS_NAME,
            function () {
                return new ShopNotificationChannelCollection();
            }
        );

        ServiceRegister::registerService(
            DefaultNotificationChannelAdapter::CLASS_NAME,
            function () {
                return new DefaultNotificationChannel();
            }
        );
    }

    /**
     * Initialize events
     */
    protected static function initEvents()
    {
        parent::initEvents();

        /** @var EventBus $eventBuss */
        $eventBuss = ServiceRegister::getService(EventBus::CLASS_NAME);

        $eventBuss->when(
            PaymentChangedWebHookEvent::CLASS_NAME,
            function (PaymentChangedWebHookEvent $event) {
                $handler = new PaymentStatusWebHookHandler();
                $handler->handle($event);
            }
        );

        $eventBuss->when(
            PaymentChangedWebHookEvent::CLASS_NAME,
            function (PaymentChangedWebHookEvent $event) {
                $handler = new OrderRefundWebHookHandler();
                $handler->handle($event);
            }
        );

        $eventBuss->when(
            OrderChangedWebHookEvent::CLASS_NAME,
            function (OrderChangedWebHookEvent $event) {
                $handler = new OrderLineRefundWebHookHandler();
                $handler->handle($event);
            }
        );

        $eventBuss->when(
            OrderChangedWebHookEvent::CLASS_NAME,
            function (OrderChangedWebHookEvent $event) {
                $handler = new OrderStatusWebHookHandler();
                $handler->handle($event);
            }
        );

        $eventBuss->when(
            OrderChangedWebHookEvent::CLASS_NAME,
            function (OrderChangedWebHookEvent $event) {
                $handler = new LineStatusWebHookHandler();
                $handler->handle($event);
            }
        );

        $eventBuss->when(
            IntegrationOrderShippedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderShippedEvent $event) {
                    $handler = new IntegrationOrderShippedEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderDeletedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderDeletedEvent $event) {
                    $handler = new IntegrationOrderDeletedEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderClosedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderClosedEvent $event) {
                    $handler = new IntegrationOrderClosedEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderCanceledEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderCanceledEvent $event) {
                    $handler = new IntegrationOrderCanceledEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderTotalChangedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderTotalChangedEvent $event) {
                    $handler = new IntegrationOrderTotalChangedEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderShippingAddressChangedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderShippingAddressChangedEvent $event) {
                    $handler = new IntegrationOrderShippingAddressChangedEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderBillingAddressChangedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderBillingAddressChangedEvent $event) {
                    $handler = new IntegrationOrderBillingAddressChangedEventHandler();
                    $handler->handle($event);
                }
            )
        );

        $eventBuss->when(
            IntegrationOrderLineChangedEvent::CLASS_NAME,
            WebHookContext::getProtectedCallable(
                function (IntegrationOrderLineChangedEvent $event) {
                    $handler = new IntegrationOrderLineChangedEventHandler();
                    $handler->handle($event);
                }
            )
        );
    }
}
