<?php

namespace Mollie\BusinessLogic\Surcharge;

/**
 * Class SurchargeType
 *
 * @package Mollie\BusinessLogic\Surcharge
 */
class SurchargeType
{
    const NO_FEE = 'no_fee';
    const FIXED_FEE = 'fixed_fee';
    const PERCENTAGE = 'percentage';
    const FIXED_FEE_AND_PERCENTAGE = 'fixed_fee_and_percentage';
}