<?php

namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class SupportedLocale
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class SupportedLocale
{
    /**
     * @var string[]
     */
    private static $defaultLocaleByLanguage = array(
        'en_' => 'en_US',
        'ca_' => 'ca_ES',
        'nb_' => 'nb_NO',
        'sv_' => 'sv_SE',
        'da_' => 'da_DK',
    );

    /**
     * @param string $locale
     *
     * @return string
     */
    public static function ensureValidLocaleFormat($locale)
    {
        if (empty($locale) || false !== strpos($locale, '_')) {
            return $locale;
        }

        if (array_key_exists("{$locale}_", static::$defaultLocaleByLanguage)) {
            return static::$defaultLocaleByLanguage["{$locale}_"];
        }

        return "{$locale}_" . strtoupper($locale);
    }
}
