<?php


namespace Mollie\Gambio\CustomFields\Providers;

/**
 * Class KlarnaCustomFieldsProvider
 *
 * @package Mollie\Gambio\CustomFields\Providers
 */
class KlarnaCustomFieldsProvider extends CustomFieldsProvider
{
    /**
     * @inheritDoc
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
     * @inheritDoc
     * @return string
     */
    protected function renderApiEdit()
    {
        return '';
    }

    /**
     * @inheritDoc
     * @return string
     */
    protected function renderApiOverview()
    {
        return '';
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function renderMultiLangEdit()
    {
        $titleKey = $this->_formatKey('CHECKOUT_NAME');
        $descKey = $this->_formatKey('CHECKOUT_DESCRIPTION');

        return mollie_multi_language_text($this->getConstantValue($titleKey), $titleKey) .
            mollie_multi_language_text($this->getConstantValue($descKey), $descKey);
    }
}