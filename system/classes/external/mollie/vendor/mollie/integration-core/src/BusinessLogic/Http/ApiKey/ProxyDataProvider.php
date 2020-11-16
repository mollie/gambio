<?php

namespace Mollie\BusinessLogic\Http\ApiKey;

use Mollie\BusinessLogic\Http\DTO\Orders\Order;
use Mollie\BusinessLogic\Http\DTO\Payment;

/**
 * Class ProxyDataProvider
 *
 * @package Mollie\BusinessLogic\Http\ApiKey
 */
class ProxyDataProvider extends \Mollie\BusinessLogic\Http\OrgToken\ProxyDataProvider
{
    protected static $profileIdRequiredEndpoints = array ();

    /**
     * @param Payment $payment
     *
     * @return array
     */
    public function transformPayment(Payment $payment)
    {
        $data = parent::transformPayment($payment);
        unset($data['profileId']);

        return $data;
    }

    /**
     * @param Order $order
     *
     * @return array
     */
    public function transformOrder(Order $order)
    {
        $data = parent::transformOrder($order);
        unset($data['profileId']);

        return $data;
    }

    /**
     * @param string $endpoint
     *
     * @return bool
     */
    protected function attachTestModeParameter($endpoint)
    {
        return false;
    }
}
