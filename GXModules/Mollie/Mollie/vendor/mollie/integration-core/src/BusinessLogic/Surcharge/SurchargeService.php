<?php

namespace Mollie\BusinessLogic\Surcharge;

use Mollie\BusinessLogic\BaseService;

/**
 * Class SurchargeService
 *
 * @package Mollie\BusinessLogic\Surcharge
 */
class SurchargeService extends BaseService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Calculates surcharge amount based on surcharge config params
     *
     * @param string $type
     * @param float $fixedAmount
     * @param float $percentage
     * @param float $limit
     * @param float $subtotal
     *
     * @return float
     */
    public function calculateSurchargeAmount($type, $fixedAmount, $percentage, $limit, $subtotal)
    {
        switch ($type) {
            case SurchargeType::NO_FEE:
                return 0;
            case SurchargeType::FIXED_FEE:
                return $fixedAmount;
            case SurchargeType::PERCENTAGE:
                $surcharge = $subtotal * $percentage / 100;

                if ($surcharge > $limit) {
                    return $limit;
                }

                return $surcharge;
            case SurchargeType::FIXED_FEE_AND_PERCENTAGE:
                $surcharge = $fixedAmount + $subtotal * $percentage / 100;

                if ($surcharge > $limit) {
                    return $limit;
                }

                return $surcharge;
        }

        return 0;
    }
}