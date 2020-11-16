<?php

use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Gambio\Services\Business\PaymentMethodService;
use Mollie\Gambio\Utility\MollieModuleChecker;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Infrastructure\ServiceRegister;

require_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/autoload.php';
require_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/mollie_config_fields.php';

/**
 * Class Mollie_OrderExtender
 * @see OrderExtenderComponent
 */
class Mollie_OrderExtender extends Mollie_OrderExtender_parent
{
    private static $shipmentStatuses = ['paid', 'authorized', 'shipping', 'completed'];
    private static $refundStatuses = ['paid', 'shipping', 'completed'];
    private static $paymentLinkStatuses = ['created', 'failed', 'canceled', 'expired'];
    /**
     * @var OrderReference
     */
    private $orderReference;
    /**
     * @var OrderInterface
     */
    private $sourceOrder;

    /**
     * @throws Exception
     */
    public function proceed()
    {
        parent::proceed();
        /** @var OrderReadServiceInterface $orderService */
        $orderService = StaticGXCoreLoader::getService('OrderRead');
        $this->sourceOrder = $orderService->getOrderById(new IdType($_GET['oID']));
        if (!$this->_showMollieDashboard()) {
            return;
        }

        $translator = new MollieTranslator();
        $this->v_output_buffer = [];

        $templatePath = PathProvider::getAdminTemplatePath('mollie_order_dashboard.html', 'OrderDashboard');
        $output       = mollie_render_template($templatePath, $this->_getTemplateData());

        $this->v_output_buffer['below_withdrawal'] = '';
        $this->v_output_buffer['below_order_info_heading'] = $translator->translate('mollie_dashboard_title');
        $this->v_output_buffer['below_order_info']         = $output;
        $this->v_output_buffer['order_status']             = '';
        $this->v_output_buffer['buttons']                  = '';

        $this->addContent();
    }

    /**
     * @return array
     */
    private function _getTemplateData()
    {
        /** @var PaymentMethodService $methodService */
        $methodService = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        $paymentMethod = $this->sourceOrder->getPaymentType()->getModule();
        $paymentTitle = $this->sourceOrder->getPaymentType()->getTitle();
        $methodConfig = $methodService->extractLocalConfiguration($paymentMethod);
        $api = $methodConfig ? $methodConfig->getApiMethod() : PaymentMethodConfig::API_METHOD_PAYMENT;
        $mollieDto = $this->_getMollieDto();
        $dashboardUrl = $mollieDto->getLink('dashboard');
        $status = $mollieDto->getStatus();

        return [
            'payment_method'          => $paymentMethod,
            'display_payment_button'  => $this->_displayPaymentLinkButton($status),
            'display_refund_button'   => in_array($status, self::$refundStatuses, true),
            'display_shipment_button' => $this->_displayShipmentButton($status, $api),
            'logo_src'                => $methodConfig ? $methodConfig->getImage() : null,
            'payment_method_desc'     => $methodConfig ? $methodConfig->getName() : $paymentTitle,
            'api_used'                => $api,
            'total_amount'            => $mollieDto->getAmount()->getAmountValue(),
            'refunded_amount'         => $mollieDto->getAmountRefunded()->getAmountValue(),
            'currency'                => $mollieDto->getAmount()->getCurrency(),
            'mollie_url'              => $dashboardUrl ? $dashboardUrl->getHref() : null,
            'status_name'             => $status
        ];
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    private function _displayPaymentLinkButton($status)
    {
        return empty($status) || in_array($status, self::$paymentLinkStatuses, true);
    }

    /**
     * @param string $status
     * @param string $apiUsed
     *
     * @return bool
     */
    private function _displayShipmentButton($status, $apiUsed)
    {
        return $apiUsed === PaymentMethodConfig::API_METHOD_ORDERS &&
            in_array($status, self::$shipmentStatuses, true);
    }

    /**
     * @return bool
     */
    private function _showMollieDashboard()
    {
        if (strpos($this->sourceOrder->getPaymentType()->getModule(), 'mollie') === false) {
            return false;
        }

        return MollieModuleChecker::isConnected() && $this->_getOrderReference();
    }

    /**
     * @return Order|Payment
     */
    private function _getMollieDto()
    {
        /** @var OrderReference $reference */
        $reference = $this->_getOrderReference();
        $payload = $reference->getPayload();

        return $reference->getApiMethod() === PaymentMethodConfig::API_METHOD_ORDERS ?
            Order::fromArray($payload) : Payment::fromArray($payload);
    }

    /**
     * @return OrderReference|null
     */
    private function _getOrderReference()
    {
        if ($this->orderReference === null) {
            /** @var OrderReferenceService $orderReferenceService */
            $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
            $this->orderReference = $orderReferenceService->getByShopReference($this->sourceOrder->getOrderId());
        }

        return $this->orderReference;
    }
}
