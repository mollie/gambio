<?php

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_banktransfer
 */
class mollie_banktransfer extends mollie
{
    public $title = 'Bank transfer';

    /**
     * @inheritDoc
     * @return array
     *
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    protected function _getHiddenFields()
    {
        $hiddenFields = parent::_getHiddenFields();
        $hiddenFields['DUE_DATE'] = [
            'value' => null,
        ];

        return $hiddenFields;
    }
}
