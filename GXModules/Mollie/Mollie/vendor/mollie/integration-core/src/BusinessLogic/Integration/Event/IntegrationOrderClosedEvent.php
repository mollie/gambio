<?php

namespace Mollie\BusinessLogic\Integration\Event;

use Mollie\Infrastructure\Utility\Events\Event;

/**
 * Class IntegrationOrderClosedEvent
 *
 * @package Mollie\BusinessLogic\Integration\Event
 */
class IntegrationOrderClosedEvent extends Event
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
     * IntegrationOrderClosedEvent constructor.
     *
     * @param string $shopReference
     */
    public function __construct($shopReference)
    {
        $this->shopReference = $shopReference;
    }

    /**
     * @return string
     */
    public function getShopReference()
    {
        return $this->shopReference;
    }
}
