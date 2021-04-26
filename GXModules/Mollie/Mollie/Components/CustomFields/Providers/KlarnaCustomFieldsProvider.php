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
}