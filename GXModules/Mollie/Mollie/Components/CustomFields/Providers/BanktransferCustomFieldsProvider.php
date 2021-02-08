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
        if ($this->isOrdersApi()) {
            return parent::renderDaysToExpireEdit();
        }

        $dueDateKey = $this->_formatKey('DUE_DATE');

        return mollie_input_integer($this->getConstantValue($dueDateKey), $dueDateKey);
    }

    /**
     * @inheritDoc
     * @return string
     * @throws \Exception
     */
    protected function renderDaysToExpireOverview()
    {
        if ($this->isOrdersApi()) {
            return parent::renderDaysToExpireOverview();
        }

        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('DUE_DATE'));
    }
}
