<?php

use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderLineChangedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderTotalChangedEvent;
use Mollie\BusinessLogic\Notifications\NotificationHub;
use Mollie\BusinessLogic\Notifications\NotificationText;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Gambio\Utility\MollieModuleChecker;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\EventBus;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieAdminApplicationTopExtender
 *
 * Class responsible
 */
class Mollie_AdminApplicationTopExtender extends Mollie_AdminApplicationTopExtender_parent
{
    private static $mollieForbiddenActions = ['product_delete', 'ot_edit', 'ot_delete'];

    /**
     * @var OrderReadService
     */
    private $orderReadService;
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * Detects mollie changes at top level (based on get and post params)
     */
    public function proceed()
    {
        try {
            if ($this->isOrderCanceled()) {
                $this->handleOrderCancel();
            }

            if (array_key_exists('oID', $_POST) && $this->_isProcessable($_POST['oID'])) {
                $this->_handleOrderLines();
            }

            parent::proceed();
        } catch (Exception $exception) {
            $messageDesc = 'mollie.payment.integration.event.notification.order_line_changed_error.description';
            $this->pushMessage('error', $messageDesc, $exception);
        }
    }

    /**
     * @return bool
     */
    private function isOrderCanceled()
    {
        return array_key_exists('orders_multi_cancel', $_POST) &&
            !empty($_POST['gm_multi_status'][0])
            && $this->_isProcessable($_POST['gm_multi_status'][0]);
    }

    /**
     * Order cancel handler
     */
    private function handleOrderCancel()
    {
        try {
            $orderId = $_POST['gm_multi_status'][0];
            NotificationHub::pushInfo(
                new NotificationText('mollie.payment.integration.event.notification.order_cancel.title'),
                new NotificationText('mollie.payment.integration.event.notification.order_cancel.description'),
                $orderId
            );
        } catch (Exception $exception) {
            $langKey = 'mollie.payment.integration.event.notification.order_cancel_error.description';
            $this->pushMessage('error', $langKey, $exception);
        }
    }

    /**
     * Order lines handler
     */
    private function _handleOrderLines()
    {
        if ($_GET['action'] === 'product_edit') {
            $this->_processOrderLine($_POST);
        }

        if (in_array($_GET['action'], self::$mollieForbiddenActions, true)) {
            $this->_getEventBus()->fire(new IntegrationOrderTotalChangedEvent($_POST['oID']));
        }
    }

    /**
     * @param array $input
     */
    private function _processOrderLine(array $input)
    {
        $orderId = $input['oID'];
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);
        $apiMethod             = $orderReferenceService->getApiMethod($orderId);

        $orderTotalChanged = $this->_isOrderTotalChange($input);

        if ($apiMethod === PaymentMethodConfig::API_METHOD_PAYMENT && $orderTotalChanged) {
            $this->_getEventBus()->fire(new IntegrationOrderTotalChangedEvent($orderId));

            return;
        }

        $this->_updateOrderLine($input, $orderTotalChanged);
    }

    /**
     * @param array $input
     * @param       $orderTotalChanged
     */
    private function _updateOrderLine(array $input, $orderTotalChanged)
    {
        $orderId     = $input['oID'];
        $storedOrder = $this->_getOrderReadService()->getOrderById(new IdType($orderId));
        $currency    = $storedOrder->getCurrencyCode()->getCode();
        $line        = new OrderLine();
        $line->setId($this->getLineIdFromMollie($orderId, $input['opID']));
        $line->setName($input['products_name']);
        if ($orderTotalChanged) {
            $line->setQuantity($input['products_quantity']);
            $line->setVatRate($input['products_tax']);
            $finalPrice = $input['products_quantity'] * $input['products_price'];

            $vatAmount = $finalPrice * ($input['products_tax'] / (100 + $input['products_tax']));

            $line->setUnitPrice(Amount::fromArray(['currency' => $currency, 'value' => $input['products_price']]));
            $line->setTotalAmount(Amount::fromArray(['currency' => $currency, 'value' => $finalPrice]));
            $line->setVatAmount(Amount::fromArray(['currency' => $currency, 'value' => $vatAmount]));
        }

        $this->_getEventBus()->fire(new IntegrationOrderLineChangedEvent($orderId, $line));
    }

    /**
     * @param $orderId
     * @param $lineId
     *
     * @return string|null
     */
    private function getLineIdFromMollie($orderId, $lineId)
    {
        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);

        if ($orderReference = $orderReferenceService->getByShopReference($orderId)) {
            $storedOrder = Order::fromArray($orderReference->getPayload());
            foreach ($storedOrder->getLines() as $line) {
                $metadata = $line->getMetadata();
                if (!empty($metadata['order_line_id']) && ((int)$metadata['order_line_id'] === (int)$lineId)) {
                    return $line->getId();
                }
            }
        }

        return null;
    }

    /**
     * @param string    $type
     * @param string    $key
     * @param Exception $exception
     */
    private function pushMessage($type, $key, $exception = null)
    {
        $translator = new MollieTranslator();

        $apiMessage = '';
        if ($exception) {
            $apiMessage = $exception->getCode() !== 500 ? $exception->getMessage() : $translator->translate('mollie_unknown_error');
        }

        $translatedMessage = $translator->translate($key, ['{api_message}' => $apiMessage]);
        $GLOBALS['messageStack']->add_session($translatedMessage, $type);
    }

    /**
     * @param array $input
     *
     * @return bool
     */
    private function _isOrderTotalChange($input)
    {
        $lineId     = $input['opID'];
        $storedItem = $this->_getOrderReadService()->getOrderItemById(new IdType($lineId));
        return (int)$storedItem->getQuantity() !== (int)$input['products_quantity']
            || number_format($storedItem->getPrice(), 2) !== number_format($input['products_price'], 2)
            || number_format($storedItem->getTax(), 2) !== number_format($input['products_tax'], 2);

    }

    /**
     * @param $orderId
     *
     * @return bool
     */
    private function _isProcessable($orderId)
    {
        if (!MollieModuleChecker::isConnected()) {
            return false;
        }

        return $this->_isMolliePaymentUsed($orderId);
    }

    /**
     * @param $orderId
     *
     * @return bool
     */
    private function _isMolliePaymentUsed($orderId)
    {
        $order         = $this->_getOrderReadService()->getOrderById(new IdType($orderId));
        $paymentMethod = $order->getPaymentType()->getModule();

        return (strpos($paymentMethod, 'mollie') !== false);
    }

    /**
     * @return OrderReadService
     */
    private function _getOrderReadService()
    {
        if ($this->orderReadService === null) {
            $this->orderReadService = StaticGXCoreLoader::getService('OrderRead');
        }

        return $this->orderReadService;
    }

    /**
     * @return EventBus
     */
    private function _getEventBus()
    {
        if ($this->eventBus === null) {
            $this->eventBus = ServiceRegister::getService(EventBus::CLASS_NAME);
        }

        return $this->eventBus;
    }
}
