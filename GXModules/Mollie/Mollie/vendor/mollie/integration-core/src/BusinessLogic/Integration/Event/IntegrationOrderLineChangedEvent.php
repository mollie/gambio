<?php

namespace Mollie\BusinessLogic\Integration\Event;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;
use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class IntegrationOrderLineChangedEvent
 *
 * @package Mollie\BusinessLogic\Integration\Event
 */
class IntegrationOrderLineChangedEvent extends Event
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
     * @var OrderLine
     */
    private $modifiedOrderLine;

    /**
     * IntegrationOrderLineChangedEvent constructor.
     *
     * @param string $shopReference
     * @param OrderLine $modifiedOrderLine
     */
    public function __construct($shopReference, OrderLine $modifiedOrderLine)
    {
        $this->shopReference = $shopReference;
        $this->modifiedOrderLine = $modifiedOrderLine;
    }

    /**
     * @return string
     */
    public function getShopReference()
    {
        return $this->shopReference;
    }

    /**
     * @return OrderLine
     */
    public function getModifiedOrderLine()
    {
        return $this->modifiedOrderLine;
    }
}
