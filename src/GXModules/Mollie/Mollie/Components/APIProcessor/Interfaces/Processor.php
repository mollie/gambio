<?php

namespace Mollie\Gambio\APIProcessor\Interfaces;

use Mollie\Gambio\APIProcessor\Result;

/**
 * Interface Processor
 *
 * @package Mollie\BusinessLogic\APIProcessor\Interfaces
 */
interface Processor
{
    /**
     * @param int $orderId
     *
     * @return Result
     */
    public function create($orderId);
}