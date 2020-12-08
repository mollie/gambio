<?php

use Mollie\BusinessLogic\Http\DTO\Address;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderBillingAddressChangedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderShippingAddressChangedEvent;
use Mollie\BusinessLogic\Integration\Event\IntegrationOrderTotalChangedEvent;
use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\BusinessLogic\OrderReference\OrderReferenceService;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Gambio\Utility\MollieModuleChecker;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Utility\Events\EventBus;

require_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/autoload.php';

/**
 * Class Mollie_OrderWriteServiceExtender
 * @see OrderWriteService
 */
class Mollie_OrderWriteServiceExtender extends Mollie_OrderWriteServiceExtender_parent
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var GXEngineOrder
     */
    private $order;

    /**
     * Update Billing Address
     *
     * Updates the customers billing address.
     *
     * @param IdType                $orderId    Order ID which holds the current address
     * @param AddressBlockInterface $newAddress New billing address
     */
    public function updateBillingAddress(IdType $orderId, AddressBlockInterface $newAddress)
    {
        try {
            $this->_processAddressChange($orderId, $newAddress, IntegrationOrderBillingAddressChangedEvent::CLASS_NAME);
        } catch (Exception $exception) {
            $this->_handleAddressUpdateException($exception, 'billing');
            return;
        }

        parent::updateBillingAddress($orderId, $newAddress);
    }


    /**
     * Update Delivery Address
     *
     * Updates the customers delivery address.
     *
     * @param IdType                $orderId    Order ID which holds the current address
     * @param AddressBlockInterface $newAddress New delivery address
     */
    public function updateDeliveryAddress(IdType $orderId, AddressBlockInterface $newAddress)
    {
        try {
            $this->_processAddressChange($orderId, $newAddress, IntegrationOrderShippingAddressChangedEvent::CLASS_NAME);
        } catch (Exception $exception) {
            $this->_handleAddressUpdateException($exception, 'shipping');
            return;
        }

        parent::updateDeliveryAddress($orderId, $newAddress);
    }

    /**
     * Updates the payment type of an order.
     * If new payment method is one of Mollie payment methods, an
     *
     * @param IdType           $orderId        Order ID of the order to update
     * @param OrderPaymentType $newPaymentType The new payment type
     */
    public function updatePaymentType(IdType $orderId, OrderPaymentType $newPaymentType)
    {
        parent::updatePaymentType($orderId, $newPaymentType);
        if (!$this->_isReferenceExists($orderId->asInt()) && $this->_isProcessable($newPaymentType->getModule())) {
            $orderReference = new OrderReference();
            $api            = $this->_getApiMethod($newPaymentType->getModule());

            $orderReference->setShopReference($orderId->asInt());
            $orderReference->setApiMethod($api);

            RepositoryRegistry::getRepository(OrderReference::getClassName())->save($orderReference);
        }
    }

    /**
     * Update Shipping Type
     *
     * Updates the shipping type of an order.
     *
     * @param IdType            $orderId         Order ID of the order to update
     * @param OrderShippingType $newShippingType The new shipping type
     */
    public function updateShippingType(IdType $orderId, OrderShippingType $newShippingType)
    {
        $this->_handleOrderTotalChange($orderId);

        return parent::updateShippingType($orderId, $newShippingType);
    }

    /**
     * @param IdType $orderId
     */
    private function _handleOrderTotalChange(IdType $orderId)
    {
        try {
            $paymentMethod = $this->_getOrder($orderId)->getPaymentType()->getModule();

            if ($this->_isProcessable($paymentMethod)) {
                $this->_getEventBus()->fire(new IntegrationOrderTotalChangedEvent($orderId->asInt()));
            }
        } catch (Exception $exception) {
            $langKey = 'mollie.payment.integration.event.notification.order_total_changed.description';
            $this->_pushErrorMessage($langKey, $exception->getMessage());
        }
    }

    /**
     * @param string $paymentModule
     *
     * @return string
     */
    private function _getApiMethod($paymentModule)
    {
        $configKey = 'MODULE_PAYMENT_' . strtoupper($paymentModule) . '_API_METHOD';

        if (defined($configKey)) {
            return @constant($configKey);
        }

        if (strpos($paymentModule, 'klarna', true)) {
            return PaymentMethodConfig::API_METHOD_ORDERS;
        }

        return PaymentMethodConfig::API_METHOD_PAYMENT;
    }

    /**
     * @param int $orderId
     *
     * @return bool
     */
    private function _isReferenceExists($orderId)
    {
        if (!MollieModuleChecker::isConnected()) {
            return false;
        }

        /** @var OrderReferenceService $orderReferenceService */
        $orderReferenceService = ServiceRegister::getService(OrderReferenceService::CLASS_NAME);

        return $orderReferenceService->getByShopReference($orderId) !== null;
    }

    /**
     * @param IdType                $orderId
     * @param AddressBlockInterface $newAddress
     * @param string                $eventClass
     */
    private function _processAddressChange(IdType $orderId, AddressBlockInterface $newAddress, $eventClass)
    {
        $paymentMethod = $this->_getOrder($orderId)->getPaymentType()->getModule();
        if ($this->_isProcessable($paymentMethod)) {
            $email = $this->_getOrder($orderId)->getCustomerEmail();
            $this->_getEventBus()->fire(new $eventClass(
                    $orderId->asInt(),
                    $this->_buildAddress($newAddress, $email))
            );
        }
    }

    /**
     * @param Exception $exception
     * @param string    $type
     */
    private function _handleAddressUpdateException(Exception $exception, $type)
    {
        $langKey           = "mollie.payment.integration.event.notification.{$type}_address_change_error.description";
        $this->_pushErrorMessage($langKey, $exception->getMessage());
    }

    /**
     * @param AddressBlockInterface $address
     * @param                       $email
     *
     * @return Address
     */
    private function _buildAddress(AddressBlockInterface $address, $email)
    {
        $mollieAddress = new Address();

        $mollieAddress->setEmail($email);
        $mollieAddress->setGivenName((string)$address->getFirstname());
        $mollieAddress->setFamilyName((string)$address->getLastname());

        $mollieAddress->setOrganizationName((string)$address->getCompany());
        $streetAndNumber = $address->getStreet() . ' ' . $address->getHouseNumber();
        $mollieAddress->setStreetAndNumber($streetAndNumber);
        $mollieAddress->setStreetAdditional((string)$address->getAdditionalAddressInfo());
        $mollieAddress->setCity((string)$address->getCity());
        $mollieAddress->setCountry((string)$address->getCountry()->getIso2());
        $mollieAddress->setPostalCode((string)$address->getPostcode());
        $mollieAddress->setRegion((string)$address->getSuburb());

        return $mollieAddress;
    }

    /**
     * @param string $langKey
     * @param string $exceptionMessage
     */
    private function _pushErrorMessage($langKey, $exceptionMessage = '')
    {
        $mollieTextManager = new MollieTranslator();
        $translated        = $mollieTextManager->translate($langKey, ['{api_message}' => $exceptionMessage]);

        $GLOBALS['messageStack']->add_session($translated, 'error');
    }

    /**
     * @param IdType $orderId
     *
     * @return GXEngineOrder
     */
    private function _getOrder(IdType $orderId)
    {
        if ($this->order === null) {
            $this->order = $this->orderRepository->getById($orderId);
        }

        return $this->order;
    }

    /**
     * @return EventBus|object
     */
    private function _getEventBus()
    {
        if ($this->eventBus === null) {
            $this->eventBus = ServiceRegister::getService(EventBus::CLASS_NAME);
        }

        return $this->eventBus;
    }

    /**
     * @param string $paymentMethod
     *
     * @return bool
     */
    private function _isProcessable($paymentMethod)
    {
        return MollieModuleChecker::isConnected() && (strpos($paymentMethod, 'mollie') !== false);
    }
}
