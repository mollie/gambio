<?php

namespace Mollie\BusinessLogic\Utility;

class CurrencySymbolService
{
    /**
     * @var array
     */
    private static $currencies = array();

    /**
     * Returns currency symbol for the provided currency.
     *
     * @param string $currency Currency ISO code.
     *
     * @return mixed
     */
    public static function getCurrencySymbol($currency)
    {
        if (empty(static::$currencies)) {
            static::$currencies = json_decode(file_get_contents(__DIR__ . '/../Resources/currencies/currencies.json'), true);
        }

        if (array_key_exists($currency, static::$currencies)) {
            return static::$currencies[$currency]['symbol'];
        }

        return $currency;
    }
}