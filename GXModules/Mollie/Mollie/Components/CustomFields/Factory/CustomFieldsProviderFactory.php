<?php

namespace Mollie\Gambio\CustomFields\Factory;

use Mollie\Gambio\CustomFields\Providers\CreditCardCustomFieldsProvider;
use Mollie\Gambio\CustomFields\Providers\CustomFieldsProvider;
use Mollie\Gambio\CustomFields\Providers\IssuerListSupportedCustomFieldsProvider;
use Mollie\Gambio\CustomFields\Providers\KlarnaCustomFieldsProvider;

/**
 * Class CustomFieldsProviderFactory
 *
 * @package Mollie\Gambio\CustomFields\Factory
 */
class CustomFieldsProviderFactory
{
    /**
     * Returns CustomFieldsProvider based on the payment method
     *
     * @param string $methodKey
     *
     * @return CustomFieldsProvider
     */
    public static function getProvider($methodKey)
    {
        if (strpos($methodKey, 'klarna') !== false) {
            return new KlarnaCustomFieldsProvider($methodKey);
        }

        if($methodKey === 'mollie_creditcard'){
            return new CreditCardCustomFieldsProvider($methodKey);
        }

        if (in_array($methodKey, ['mollie_ideal', 'mollie_kbc', 'mollie_giftcard'], true)) {
            return new IssuerListSupportedCustomFieldsProvider($methodKey);
        }

        return new CustomFieldsProvider($methodKey);
    }
}
