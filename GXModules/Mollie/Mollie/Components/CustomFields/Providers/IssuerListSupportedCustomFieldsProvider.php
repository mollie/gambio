<?php


namespace Mollie\Gambio\CustomFields\Providers;

/**
 * Class IssuerListSupportedCustomFieldsProvider
 *
 * @package Mollie\Gambio\CustomFields\Providers
 */
class IssuerListSupportedCustomFieldsProvider extends CustomFieldsProvider
{
    /**
     * @inheritDoc
     * @return string
     * @throws \Exception
     */
    public function renderAllCustomFields()
    {
        $issuerListKey = $this->_formatKey('ISSUER_LIST');

        return parent::renderAllCustomFields() .
            mollie_issuer_list_select($this->getConstantValue($issuerListKey), $issuerListKey);
    }

    /**
     * @inheritDoc
     * @return string
     * @throws \Exception
     */
    public function renderCustomOverviewFields()
    {
        return parent::renderCustomOverviewFields() .
            mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('ISSUER_LIST'));
    }
}
