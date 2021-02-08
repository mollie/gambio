<?php

namespace Mollie\Gambio\CustomFields\Providers;

/**
 * Class BanktransferCustomFieldsProvider
 *
 * @package Mollie\Gambio\CustomFields\Providers
 */
class BanktransferCustomFieldsProvider extends CustomFieldsProvider
{
    /**
     * @inheritDoc
     * @return string
     * @throws \Exception
     */
    protected function renderDaysToExpireEdit()
    {
        $dueDateKey = $this->_formatKey('DUE_DATE');

        return parent::renderDaysToExpireEdit() .
            mollie_input_integer($this->getConstantValue($dueDateKey), $dueDateKey);
    }

    /**
     * @inheritDoc
     * @return string
     * @throws \Exception
     */
    protected function renderDaysToExpireOverview()
    {
        return parent::renderDaysToExpireOverview() .
            mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('DUE_DATE'));
    }
}
