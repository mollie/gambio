<?php

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_kbc
 */
class mollie_kbc extends mollie
{
    public $title = 'KBC/CBC Payment Button';

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
