<?php

namespace Mollie\Gambio\CustomFields\Providers;

use Exception;

class CreditCardCustomFieldsProvider extends CustomFieldsProvider
{
    public function renderAllCustomFields()
    {
        return parent::renderAllCustomFields() .
            $this->renderSwitcher('COMPONENTS_STATUS') .
            $this->renderSwitcher('SINGLE_CLICK_STATUS') .
            $this->renderSingleClickApprovalTextEdit() .
            $this->renderSingleClickDescriptionEdit();
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function renderSingleClickApprovalTextEdit()
    {
        $singleClickApprovalText = $this->_formatKey('SINGLE_CLICK_APPROVAL_TEXT');

        return mollie_multi_language_text($this->getConstantValue($singleClickApprovalText), $singleClickApprovalText);
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function renderSingleClickDescriptionEdit()
    {
        $singleClickDescription = $this->_formatKey('SINGLE_CLICK_DESCRIPTION');

        return mollie_multi_language_text($this->getConstantValue($singleClickDescription), $singleClickDescription);
    }

    /**
     * @throws Exception
     */
    protected function renderSwitcher($key)
    {
        $switcher = $this->_formatKey($key);

        return mollie_switcher($switcher);
    }
}