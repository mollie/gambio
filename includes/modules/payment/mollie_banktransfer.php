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
     */
    public function _configuration()
    {
        $config = parent::_configuration();
        $config['DUE_DATE'] = [
            'configuration_value' => null,
            'set_function'        => 'mollie_input_integer( ',
        ];

        return $config;
    }
}
