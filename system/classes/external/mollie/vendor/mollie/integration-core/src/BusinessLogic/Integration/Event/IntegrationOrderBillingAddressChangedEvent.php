<?php

namespace Mollie\BusinessLogic\Integration\Event;

use Mollie\BusinessLogic\Http\DTO\Address;
use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class IntegrationOrderBillingAddressChangedEvent
 *
 * @package Mollie\BusinessLogic\Integration\Event
 */
class IntegrationOrderBillingAddressChangedEvent extends Event
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $shopReference;
    /**
     * @var Address
     */
    private $billingAddress;

    /**
     * IntegrationOrderBillingAddressChangedEvent constructor.
     *
     * @param string $shopReference
     * @param Address $billingAddress
     */
    public function __construct($shopReference, Address $billingAddress)
    {
        $this->shopReference = $shopReference;
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return string
     */
    public function getShopReference()
    {
        return $this->shopReference;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }
}
