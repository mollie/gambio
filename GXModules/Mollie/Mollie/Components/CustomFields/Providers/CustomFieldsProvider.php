<?php

namespace Mollie\Gambio\CustomFields\Providers;

use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Gambio\Utility\PathProvider;

/**
 * Class CustomFieldsProvider
 *
 * @package Mollie\Gambio\CustomFields\Providers
 */
class CustomFieldsProvider
{
    const MAX_OVERVIEW_TEXT_LENGTH = 30;
    /**
     * @var string
     */
    protected $module;
    /**
     * @var string
     */
    protected $overviewTemplatePath;


    /**
     * CustomFieldsProvider constructor.
     *
     * @param string $module
     */
    public function __construct($module)
    {
        $this->module = $module;
        $this->overviewTemplatePath = PathProvider::getAdminTemplatePath('mollie_custom_overview.html', 'ConfigFields');
    }

    /**
     * Renders all custom fields inputs (used for edit value)
     *
     * @return string
     * @throws \Exception
     */
    public function renderAllCustomFields()
    {
        return $this->renderLogoEdit() .
            $this->renderMultiLangEdit() .
            $this->renderApiEdit() .
            $this->renderDaysToExpireEdit() .
            $this->renderCountryZonesEdit();
    }

    /**
     * Renders all custom fields in method overview page (read only)
     * @return string
     * @throws \Exception
     */
    public function renderCustomOverviewFields()
    {
        return $this->renderLogoOverview() .
            $this->renderMultiLangFieldsOverview() .
            $this->renderApiOverview() .
            $this->renderDaysToExpireOverview() .
            $this->renderCountryZonesOverview();
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderDaysToExpireOverview()
    {
        return $this->isOrdersApi() ?
            mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('ORDER_EXPIRES')) :
            '';
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderDaysToExpireEdit()
    {
        $orderExpiresKey = $this->_formatKey('ORDER_EXPIRES');

        return $this->isOrdersApi() ?
            mollie_input_integer($this->getConstantValue($orderExpiresKey), $orderExpiresKey) : '';
    }

    /**
     * Returns logo config overview
     *
     * @return string
     * @throws \Exception
     */
    protected function renderLogoOverview()
    {
        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('LOGO'));
    }

    /**
     * Renders logo edit
     *
     * @return string
     */
    protected function renderLogoEdit()
    {
        $logoKey = $this->_formatKey('LOGO');

        return mollie_logo_upload($this->getConstantValue($logoKey), $logoKey);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderMultiLangFieldsOverview()
    {
        $transactionDesc = !$this->isOrdersApi() ?
            mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('TRANSACTION_DESCRIPTION')) :
            '';

        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('CHECKOUT_NAME')) .
            mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('CHECKOUT_DESCRIPTION')) .
            $transactionDesc;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderMultiLangEdit()
    {
        $titleKey = $this->_formatKey('CHECKOUT_NAME');
        $descKey = $this->_formatKey('CHECKOUT_DESCRIPTION');

        $transactionDescKey = $this->_formatKey('TRANSACTION_DESCRIPTION');
        $transactionDescEdit = !$this->isOrdersApi() ?
            mollie_multi_language_text($this->getConstantValue($transactionDescKey), $transactionDescKey) :
            '';

        return mollie_multi_language_text($this->getConstantValue($titleKey), $titleKey) .
            mollie_multi_language_text($this->getConstantValue($descKey), $descKey) .
            $transactionDescEdit;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderApiOverview()
    {
        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('API_METHOD'));
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderApiEdit()
    {
        $apiMethodKey = $this->_formatKey('API_METHOD');

        return mollie_api_select($this->getConstantValue($apiMethodKey), $apiMethodKey);
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderCountryZonesOverview()
    {
        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('ALLOWED_ZONES'));
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderCountryZonesEdit()
    {
        $zonesKey = $this->_formatKey('ALLOWED_ZONES');

        return mollie_multi_select_countries($this->getConstantValue($zonesKey), $zonesKey);
    }

    /**
     * @param string $key
     *
     * @return array|null[]
     */
    protected function _formatOverviewData($key)
    {
        $value = $this->getConstantValue($this->_formatKey($key));
        $value = strlen($value) > static::MAX_OVERVIEW_TEXT_LENGTH ?
            substr($value, 0, self::MAX_OVERVIEW_TEXT_LENGTH) . ' ...' : $value;

        return [
            'title' => $this->getConstantValue($this->_formatKey("{$key}_TITLE")),
            'value' => $value
        ];
    }

    /**
     * @return bool
     */
    protected function isOrdersApi()
    {
        return $this->getConstantValue($this->_formatKey('API_METHOD')) === PaymentMethodConfig::API_METHOD_ORDERS;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    protected function getConstantValue($key)
    {
        return defined($key) ? @constant($key) : null;
    }

    /**
     * @param string $baseKey
     *
     * @return string
     */
    protected function _formatKey($baseKey)
    {
        return 'MODULE_PAYMENT_' . strtoupper($this->module) . '_' . $baseKey;
    }
}
