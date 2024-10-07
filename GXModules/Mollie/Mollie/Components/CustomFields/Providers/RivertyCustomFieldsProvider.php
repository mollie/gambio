<?php

namespace Mollie\Gambio\CustomFields\Providers;

/**
 * Class RivertyCustomFieldsProvider
 *
 * @package Mollie\Gambio\CustomFields\Providers
 */
class RivertyCustomFieldsProvider extends CustomFieldsProvider
{
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
