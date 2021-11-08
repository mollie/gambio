<?php

use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_klarnapaynow
 */
class mollie_klarnapaynow extends mollie
{
    public $title = 'Pay now';

    /**
     * @inheritDoc
     * @return array
     */
    public function keys()
    {
        $keys   = parent::keys();
        $hidden = $this->_formatKey('API_METHOD');

        return array_values(array_diff($keys, [$hidden]));
    }

    /**
     * @return string
     */
    protected function _getDefaultApi()
    {
        return PaymentMethodConfig::API_METHOD_ORDERS;
    }
}