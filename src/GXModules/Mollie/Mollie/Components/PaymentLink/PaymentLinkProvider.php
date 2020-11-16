<?php


namespace Mollie\Gambio\PaymentLink;

use Mollie\BusinessLogic\CheckoutLink\CheckoutLinkService;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\Payments\PaymentService;
use Mollie\Gambio\Mappers\OrderMapper;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class PaymentLinkProvider
 *
 * @package Mollie\Gambio\PaymentLink
 */
class PaymentLinkProvider
{
    /**
     * @var OrderReferenceService
     */
    private $orderReferenceService;
    /**
     * @var CheckoutLinkService
     */
    private $checkoutLinkService;
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var PaymentService
     */
    private $paymentService;
    /**
     * @var OrderMapper
     */
    private $dtoMapper;

    /**
     * PaymentLinkProvider constructor.
     */
    public function __construct()
    {
        $this->checkoutLinkService = ServiceRegister::getService(CheckoutLinkService::CLASS_NAME);
        $this->orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        $this->orderService = ServiceRegister::getService(OrderService::CLASS_NAME);
        $this->paymentService = ServiceRegister::getService(PaymentService::CLASS_NAME);
        $this->dtoMapper = new OrderMapper();
    }

    /**
     * @param int $shopReference
     *
     * @return \Mollie\BusinessLogic\Http\DTO\Link|null
     * @throws \Mollie\BusinessLogic\CheckoutLink\Exceptions\CheckoutLinkNotAvailableException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function createPaymentAndGetCheckoutLink($shopReference)
    {
        $orderReference = $this->orderReferenceService->getByShopReference($shopReference);
        if ($orderReference && !$orderReference->getMollieReference()) {
            $this->createPayment($shopReference, $orderReference->getApiMethod());
        }

        return $this->checkoutLinkService->getCheckoutLink($shopReference);

    }

    /**
     * @param int $shopReference
     * @param string $api
     *
     * @return \Mollie\BusinessLogic\Http\DTO\Orders\Order|\Mollie\BusinessLogic\Http\DTO\Payment
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function createPayment($shopReference, $api)
    {
        if ($api === PaymentMethodConfig::API_METHOD_PAYMENT) {
            return $this->paymentService->createPayment($shopReference, $this->dtoMapper->getPayment($shopReference));
        }

        return $this->orderService->createOrder($shopReference, $this->dtoMapper->getOrder($shopReference));
    }
}
