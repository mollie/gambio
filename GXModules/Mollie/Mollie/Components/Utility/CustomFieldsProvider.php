<?php


namespace Mollie\Gambio\Utility;

/**
 * Class CustomFieldsProvider
 *
 * @package Mollie\Gambio\Utility
 */
class CustomFieldsProvider
{
    const MAX_OVERVIEW_TEXT_LENGTH = 50;

    private $module;

    /**
     * CustomFieldsProvider constructor.
     *
     * @param $module
     */
    public function __construct($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function renderAllCustomFields()
    {
        $logoKey = $this->_formatKey('LOGO');
        $apiMethodKey = $this->_formatKey('API_METHOD');
        $zonesKey = $this->_formatKey('ALLOWED_ZONES');
        $titleKey = $this->_formatKey('CHECKOUT_NAME');
        $descKey = $this->_formatKey('CHECKOUT_DESCRIPTION');
        $issuerListKey = $this->_formatKey('ISSUER_LIST');

        $apiMethod = $this->_isKlarna() ?
            mollie_api_select($this->getConstantValue($apiMethodKey), $apiMethodKey) : '';

        $issuerList = $this->_isIssuersSupported() ?
            mollie_issuer_list_select($this->getConstantValue($issuerListKey), $issuerListKey) : '';

        return mollie_logo_upload($this->getConstantValue($logoKey), $logoKey) .
            mollie_multi_language_text($this->getConstantValue($titleKey), $titleKey) .
            mollie_multi_language_text($this->getConstantValue($descKey), $descKey).
            $apiMethod .
            mollie_multi_select_countries($this->getConstantValue($zonesKey), $zonesKey) .
            $issuerList;
    }

    /**
     * @return string|string[]
     * @throws \Exception
     */
    public function renderCustomOverviewFields()
    {
        $templatePath = PathProvider::getAdminTemplatePath('mollie_custom_overview.html', 'ConfigFields');

        $apiMethod = $this->_isKlarna() ?
            mollie_render_template($templatePath, $this->_formatOverviewData('API_METHOD')) : '';

        $issuerList = $this->_isIssuersSupported() ?
            mollie_render_template($templatePath, $this->_formatOverviewData('ISSUER_LIST')) : '';

        return mollie_render_template($templatePath, $this->_formatOverviewData('LOGO')) .
            mollie_render_template($templatePath, $this->_formatOverviewData('CHECKOUT_NAME')) .
            mollie_render_template($templatePath, $this->_formatOverviewData('CHECKOUT_DESCRIPTION')) .
            $apiMethod .
            mollie_render_template($templatePath, $this->_formatOverviewData('ALLOWED_ZONES')) .
            $issuerList;
    }

    /**
     * @return bool
     */
    private function _isKlarna()
    {
        return strpos($_GET['module'], 'klarna') === false;
    }

    /**
     * @return bool
     */
    private function _isIssuersSupported()
    {
        return in_array($_GET['module'], ['mollie_ideal', 'mollie_kbc', 'mollie_giftcard'], true);
    }

    /**
     * @param string $key
     *
     * @return array|null[]
     */
    private function _formatOverviewData($key)
    {
        $value = $this->getConstantValue($this->_formatKey($key));
        $value = strlen($value) > static::MAX_OVERVIEW_TEXT_LENGTH ?
            substr($value, 0, self::MAX_OVERVIEW_TEXT_LENGTH) . ' ...' : $value;

        return [
            'title' => $this->getConstantValue($this->_formatKey("{$key}_TITLE")),
            'value' => $value,
        ];
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    private function getConstantValue($key)
    {
        return defined($key) ? @constant($key) : null;
    }

    /**
     * @param string $baseKey
     *
     * @return string
     */
    private function _formatKey($baseKey)
    {
        return 'MODULE_PAYMENT_' . strtoupper($this->module) . '_' . $baseKey;
    }
}
