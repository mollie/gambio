<?php


namespace Mollie\Gambio\OrderReset;


class ReshipService
{
    /**
     * @param array $order
     */
    public function reship($order)
    {
        require_once(DIR_FS_CATALOG . 'gm/inc/set_shipping_status.php');
        set_shipping_status($order['products_id'], $order['products_properties_combis_id']);
    }
}
