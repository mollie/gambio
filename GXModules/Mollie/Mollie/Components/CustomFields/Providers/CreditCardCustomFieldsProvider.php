<?php

namespace Mollie\Gambio\CustomFields\Providers;

use Exception;

class CreditCardCustomFieldsProvider extends CustomFieldsProvider
{
    /**
     * @inheritDoc
     *
     * @return string
     * @throws Exception
     */
    public function renderAllCustomFields()
    {
        return parent::renderAllCustomFields() .
            $this->renderSwitcher('COMPONENTS_STATUS') .
            $this->renderSwitcher('SINGLE_CLICK_STATUS') .
            $this->renderSingleClickApprovalTextEdit() .
            $this->renderSingleClickDescriptionEdit();
    }

    /**
     * @inheritDoc
     *
     * @return string
     * @throws Exception
     */
    public function renderCustomOverviewFields()
    {
        return parent::renderCustomOverviewFields() .
            $this->renderSwitcherOverview('COMPONENTS_STATUS') .
            $this->renderSwitcherOverview('SINGLE_CLICK_STATUS') .
            $this->renderSingleClickApprovalTextOverview() .
            $this->renderSingleClickDescriptionOverview();
    }

    /**
     * Returns single click approval text overview
     *
     * @return string
     * @throws \Exception
     */
    protected function renderSingleClickApprovalTextOverview()
    {
        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('SINGLE_CLICK_APPROVAL_TEXT'));
    }

    /**
     * Returns single click approval text field
     *
     * @return string
     * @throws Exception
     */
    protected function renderSingleClickApprovalTextEdit()
    {
        $singleClickApprovalText = $this->_formatKey('SINGLE_CLICK_APPROVAL_TEXT');

        return mollie_multi_language_text($this->getConstantValue($singleClickApprovalText), $singleClickApprovalText);
    }

    /**
     * Returns single click description overview
     *
     * @return string
     * @throws \Exception
     */
    protected function renderSingleClickDescriptionOverview()
    {
        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData('SINGLE_CLICK_DESCRIPTION'));
    }

    /**
     * Returns single click description field
     *
     * @return string
     * @throws Exception
     */
    protected function renderSingleClickDescriptionEdit()
    {
        $singleClickDescription = $this->_formatKey('SINGLE_CLICK_DESCRIPTION');

        return mollie_multi_language_text($this->getConstantValue($singleClickDescription), $singleClickDescription);
    }

    /**
     * Returns switcher overview
     *
     * @throws Exception
     */
    protected function renderSwitcherOverview($key)
    {
        return mollie_render_template($this->overviewTemplatePath, $this->_formatOverviewData($key));
    }

    /**
     * Returns switcher field
     *
     * @throws Exception
     */
    protected function renderSwitcher($key)
    {
        $switcher = $this->_formatKey($key);

        return mollie_switcher($switcher);
    }
}