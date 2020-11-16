<?php


namespace Mollie\Gambio\Utility;

/**
 * Class UrlProvider
 *
 * @package Mollie\Gambio\Utility
 */
class UrlProvider
{

    /**
     * @param string $jsFile
     *
     * @return string
     */
    public static function getPluginJavascriptUrl($jsFile)
    {
        return static::getPluginAssetsAdmin() . "Javascripts/$jsFile";
    }

    /**
     * @param string $cssFile
     *
     * @return string
     */
    public static function getPluginCssUrl($cssFile)
    {
        return static::getPluginAssetsAdmin() . "Styles/$cssFile";
    }

    /**
     * @return string
     */
    public static function getPluginAssetsAdmin()
    {
        return DIR_WS_CATALOG . 'admin/html/assets/mollie/';
    }

    /**
     * Generates admin url based on provided parameters
     *
     * @param string $page
     * @param string $action
     * @param array  $queryParams
     *
     * @return string
     */
    public static function generateAdminUrl($page, $action = '', $queryParams = [])
    {
        return xtc_href_link($page, static::_getQueryString($action, $queryParams));
    }

    /**
     * Generates shop url based on provided parameters
     *
     * @param string $page
     * @param string $action
     * @param array $queryParams
     *
     * @return string
     */
    public static function generateShopUrl($page, $action = '', array $queryParams = [])
    {
        $queryString = static::_getQueryString($action, $queryParams);
        if (function_exists('xtc_catalog_href_link'))
        {
            return xtc_catalog_href_link($page, $queryString);
        }

        return xtc_href_link($page, $queryString);
    }

    /**
     * @param $action
     * @param $queryParams
     *
     * @return string
     */
    private static function _getQueryString($action, $queryParams)
    {
        $queryString = '';
        if (!empty($action)) {
            $queryString = "do=$action";
        }

        if (!empty($queryParams)) {
            $separator = !empty($queryString) ? '&' : '';
            $queryString .= $separator . http_build_query($queryParams);
        }

        return $queryString;
    }
}
