<?php

namespace Mollie\BusinessLogic\Surcharge;

/**
 * Interface SurchargeCalculationService
 *
 * @package Mollie\BusinessLogic\Surcharge
 */
interface SurchargeCalculationService
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Calculates surcharge amount based on surcharge config params
     *
     * @param string $type
     * @param float $fixedAmount
     * @param float $percentage
     * @param float $limit
     * @param float $subtotal
     *
     * @return mixed
     */
    public function calculateSurchargeAmount($type, $fixedAmount, $percentage, $limit, $subtotal);
}