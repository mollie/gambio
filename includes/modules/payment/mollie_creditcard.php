<?php

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_ccard
 */
class mollie_creditcard extends mollie
{
    public $title = 'Credit card';

    public function _configuration()
    {
        $config = parent::_configuration();
        $config['COMPONENTS_STATUS'] = [
            'configuration_value' => 'True',
            'set_function'        => 'gm_cfg_select_option(array(\'True\', \'False\'), ',
        ];

        return $config;
    }
}