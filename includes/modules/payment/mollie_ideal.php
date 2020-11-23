<?php

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_ideal
 */
class mollie_ideal extends mollie
{
    public $title = 'iDEAL';

    /**
     * @inheritDoc
     * @return string[][]
     */
    public function _configuration()
    {
        $config = parent::_configuration();
        $config['ISSUER_LIST'] = [
            'configuration_value' => 'none',
            'set_function'        => 'mollie_issuer_list_select( ',
        ];

        return $config;
    }
}