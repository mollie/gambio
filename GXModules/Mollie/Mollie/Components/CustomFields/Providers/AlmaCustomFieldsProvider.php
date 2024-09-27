<?php

namespace Mollie\Gambio\CustomFields\Providers;

class AlmaCustomFieldsProvider extends CustomFieldsProvider
{
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
            $this->renderCountryZonesEdit() .
            $this->renderSurchargeTypeSelection() .
            $this->renderSurchargeEditFields();
    }

    /**
     * @inheritDoc
     *
     * @return string
     * @throws \Exception
     */
    public function renderCustomOverviewFields()
    {
        return $this->renderLogoOverview() .
            $this->renderMultiLangFieldsOverview() .
            $this->renderApiOverview() .
            $this->renderCountryZonesOverview().
            $this->renderSurchargeTypeOverview() .
            $this->renderSurchargeFieldsOverview();
    }

    /**
     * @return string
     */
    protected function renderApiEdit()
    {
        return '';
    }

    /**
     * @return string
     */
    protected function renderDaysToExpireOverview()
    {
        return '';
    }
}
