<?php

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\BusinessLogic\Http\DTO\Orders\Tracking;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderShippedEvent;
use Mollie\BusinessLogic\Orders\OrderService;
use Mollie\BusinessLogic\Shipments\ShipmentService;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\EventBus;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieShipmentController
 */
class MollieShipmentController extends AdminHttpViewController
{
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var ShipmentService
     */
    private $shipmentService;

    /**
     * @return AdminLayoutHttpControllerResponse
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function actionDefault()
    {
        $template = PathProvider::getAdminTemplate('shipment.html', 'OrderDashboard/Popups');
        $title    = new NonEmptyStringType('Mollie Configuration');
        $data     = MainFactory::create('KeyValueCollection', $this->_getTemplateData());

        return MainFactory::create('AdminLayoutHttpControllerResponse', $title, $template, $data);
    }

    /**
     * @return JsonHttpControllerResponse
     */
    public function actionSubmitShipment()
    {
        $messageKey  = 'mollie_shipment_create_success';
        $messageType = 'success';
        $apiMsg      = '';
        $orderId     = $this->_getQueryParameter('orders_id');
        try {
            $payload = json_decode(file_get_contents('php://input'), true);

            /** @var EventBus $eventBus */
            $eventBus = ServiceRegister::getService(EventBus::CLASS_NAME);
            $eventBus->fire(new IntegrationOrderShippedEvent(
                    $orderId,
                    $this->_getTracking($payload['tracking']),
                    $this->_getLineItems($payload['lines']))
            );
        } catch (Exception $exception) {
            $messageKey  = 'mollie_shipment_create_error';
            $messageType = 'error';
            $apiMsg      = $exception->getMessage();
        }

        $this->_pushMessage($messageKey, $apiMsg, $messageType);

        $data['success'] = true;

        return MainFactory::create('JsonHttpControllerResponse', $data);
    }

    /**
     * @param $itemsPayload
     *
     * @return array
     */
    private function _getLineItems($itemsPayload)
    {
        $items = [];
        foreach ($itemsPayload as $item) {
            if (empty($item['id'])) {
                throw new InvalidArgumentException('Order line ID not set on shipment item');
            }

            $items[] = OrderLine::fromArray($item);
        }

        return $items;
    }

    /**
     * @param array $trackingPayload
     *
     * @return \Mollie\BusinessLogic\Http\DTO\BaseDto|Tracking|null
     */
    private function _getTracking($trackingPayload)
    {
        if (!array_filter($trackingPayload)) {
            return null;
        }

        if (empty($trackingPayload['carrier'])) {
            throw new InvalidArgumentException('Carrier not set on tracking object');
        }

        if (empty($trackingPayload['code'])) {
            throw new InvalidArgumentException('Carrier not set on tracking object');
        }

        return Tracking::fromArray($trackingPayload);
    }

    /**
     * @return array
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\BusinessLogic\OrderReference\Exceptions\ReferenceNotFoundException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _getTemplateData()
    {
        $orderId = $this->_getQueryParameter('orders_id');
        $shippableItems = $this->_getShippableItems($orderId);
        return [
            'js_admin'              => UrlProvider::getPluginJavascriptUrl(''),
            'css_admin'             => UrlProvider::getPluginCssUrl(''),
            'is_shippable'          => !empty($shippableItems),
            'shipments'             => $this->_getAllShipments($orderId),
            'shippable_order_lines' => $this->_getShippableItems($orderId),
            'process_shipment_url'  => UrlProvider::generateAdminUrl(
                'admin.php',
                'MollieShipment/submitShipment',
                ['orders_id' => $orderId]
            ),
        ];
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
     * @return ShipmentService
     */
    private function _getShipmentService()
    {
        if ($this->shipmentService === null) {
            $this->shipmentService = ServiceRegister::getService(ShipmentService::CLASS_NAME);
        }

        return $this->shipmentService;
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
    private function _getAllShipments($orderId)
    {
        $shipments = [];
        foreach ($this->_getShipmentService()->getShipments($orderId) as $shipment) {
            $shipmentMap = $shipment->toArray();
            $shipmentMap['createdAt'] = $shipment->getCreatedAt()->format('d.m.y - H:i');

            $shipments[] = $shipmentMap;
        }

        return $shipments;
    }

    /**
     * @param int $orderId
     *
     * @return array
     */
    private function _getShippableItems($orderId)
    {
        $items          = [];
        $order = $this->_getOrderService()->getOrder($orderId);
        if ($order) {
            foreach ($order->getLines() as $orderLine) {
                if ((int)$orderLine->getShippableQuantity() > 0) {
                    $items [] = $orderLine->toArray();
                }
            }
        }

        return $items;
    }

    /**
     * @param string $messageKey
     * @param string $apiMsg
     * @param string $messageType
     */
    private function _pushMessage($messageKey, $apiMsg, $messageType)
    {
        $languageTextManager = new MollieTranslator();
        $message             = $languageTextManager->translate($messageKey, ['{api_message}' => $apiMsg]);
        $GLOBALS['messageStack']->add_session($message, $messageType);
    }
}
