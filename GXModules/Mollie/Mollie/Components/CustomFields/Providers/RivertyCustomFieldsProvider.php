<?php

namespace Mollie\Gambio\CustomFields\Providers;

use Exception;

/**
 * Class RivertyCustomFieldsProvider
 *
 * @package Mollie\Gambio\CustomFields\Providers
 */
class RivertyCustomFieldsProvider extends CustomFieldsProvider
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
            $this->renderCaptureEdit();
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
            $this->renderCaptureOverview();
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
