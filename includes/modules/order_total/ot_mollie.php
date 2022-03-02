<?php

use Mollie\BusinessLogic\Surcharge\SurchargeService;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class ot_mollie
 */
class ot_mollie
{
    const DEFAULT_OT_MOLLIE_SORT_ORDER = 95;

    public $code;
    public $header;
    public $title;
    public $description;
    public $sort_order;
    public $tax_class;
    public $output;
    public $enabled;

    /**
     * ot_mollie constructor.
     */
    public function __construct()
    {
        include(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/order_total/mollie.php');
        $this->code        = get_class($this);
        $this->header      = defined('MODULE_ORDER_TOTAL_MOLLIE_HEADER') ? MODULE_ORDER_TOTAL_MOLLIE_HEADER : '';
        $this->title       = defined('MODULE_ORDER_TOTAL_MOLLIE_TITLE') ? MODULE_ORDER_TOTAL_MOLLIE_TITLE : '';
        $this->description = defined('MODULE_ORDER_TOTAL_MOLLIE_DESCRIPTION') ? MODULE_ORDER_TOTAL_MOLLIE_DESCRIPTION : '';
        $this->sort_order  = defined('MODULE_ORDER_TOTAL_MOLLIE_SORT_ORDER') ? MODULE_ORDER_TOTAL_MOLLIE_SORT_ORDER : '0';
        $this->tax_class   = defined('MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS') ? MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS : '0';
        $this->output      = [];
        $this->enabled     = defined('MODULE_ORDER_TOTAL_MOLLIE_STATUS') ?
            strtolower(MODULE_ORDER_TOTAL_MOLLIE_STATUS) === 'true' : false;
    }


    /**
     * Displays surcharge on checkout screen and modifies total price
     */
    public function process()
    {
        global $xtPrice;
        global $order;
        $paymentMethod = $order->info['payment_method'];
        $surchargeType = @constant('MODULE_PAYMENT_' . strtoupper($paymentMethod) . '_SURCHARGE_TYPE');
        $surchargeFixedAmount = @constant('MODULE_PAYMENT_' . strtoupper($paymentMethod) . '_SURCHARGE_FIXED_AMOUNT');
        $surchargePercentage = @constant('MODULE_PAYMENT_' . strtoupper($paymentMethod) . '_SURCHARGE_PERCENTAGE');
        $surchargeLimit = @constant('MODULE_PAYMENT_' . strtoupper($paymentMethod) . '_SURCHARGE_LIMIT');
        if ($surchargeType !== null && $surchargeFixedAmount !== null && $surchargePercentage !== null && $surchargeLimit !== null) {
            $surcharge = $this->getSurchargeService()->calculateSurchargeAmount($surchargeType, $surchargeFixedAmount, $surchargePercentage, $surchargeLimit, $order->info['total']);
        }

        if (!empty($surcharge) && strpos($paymentMethod, 'mollie') !== false) {
            $taxRate = xtc_get_tax_rate($this->tax_class);
            if ($taxRate) {
                $taxDesc = xtc_get_tax_description($this->tax_class);
                $taxAmount = xtc_add_tax($surcharge, $taxRate) - $surcharge;
                $order->info['tax'] += $taxAmount;
                $order->info['tax_groups'][TAX_ADD_TAX . "$taxDesc"] += $taxAmount;

                $surcharge = xtc_add_tax($surcharge, $taxRate); // modify final surcharge
            }

            $order->info['total'] += $surcharge;
            $surchargeValue = $xtPrice->xtcFormat($surcharge, false);

            $this->output[] = [
                'title' => $this->title . ':',
                'text'  => $xtPrice->xtcFormat($surcharge, true),
                'value' => $surchargeValue,
            ];
        }
    }

    /**
     * Method pre_confirmation_check is called on checkout confirmation. It's function is to decide whether the
     * credits available are greater than the order total. If they are then a variable (credit_covers) is set to
     * true. This is used to bypass the payment method. In other words if the Gift Voucher is more than the order
     * total, we don't want to go to paypal etc.
     *
     * @param $order_total
     * @return bool
     */
    public function pre_confirmation_check($order_total)
    {
        return false;
    }

    /**
     * Method update_credit_account is called in checkout process on a per product basis. It's purpose
     * is to decide whether each product in the cart should add something to a credit account.
     * e.g. for the Gift Voucher it checks whether the product is a Gift voucher and then adds the amount
     * to the Gift Voucher account.
     * Another use would be to check if the product would give reward points and add these to the points/reward account.
     *
     * @param $i
     * @return bool
     */
    public function update_credit_account($i)
    {
        return false;
    }

    /**
     * Check module's status.
     *
     * @return bool
     */
    public function check()
    {
        if (!isset($this->check)) {
            $query = xtc_db_query(
                'SELECT configuration_value 
                 FROM ' . TABLE_CONFIGURATION . " 
                 WHERE configuration_key = 'MODULE_ORDER_TOTAL_MOLLIE_STATUS'"
            );

            $this->check = xtc_db_num_rows($query);
        }

        return $this->check;
    }

    /**
     * Returns configuration parameters which will be displayed on ot_mollie module config screen.
     *
     * @return string[]
     */
    public function keys()
    {
        return array_keys($this->_configuration());
    }

    /**
     * @return SurchargeService
     */
    protected function getSurchargeService()
    {
        /** @var SurchargeService $surchargeService */
        $surchargeService = ServiceRegister::getService(SurchargeService::CLASS_NAME);

        return $surchargeService;
    }

    /**
     * Returns configuration parameters for ot_mollie module.
     *
     * @return string[][]
     */
    protected function _configuration()
    {
        return [
            'MODULE_ORDER_TOTAL_MOLLIE_STATUS'     => [
                'configuration_value' => 'True',
                'set_function'        => 'gm_cfg_select_option(array(\'True\', \'False\'), ',
            ],
            'MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS'  => [
                'configuration_value' => '0',
                'set_function'        => 'xtc_cfg_pull_down_tax_classes( ',
                'use_function'        => 'xtc_get_tax_class_title',
            ],
            'MODULE_ORDER_TOTAL_MOLLIE_SORT_ORDER' => [
                'configuration_value' => self::DEFAULT_OT_MOLLIE_SORT_ORDER,
            ],
        ];
    }

    /**
     * Returns fields that will not be displayed on ot_mollie config screen
     *
     * @return string[][]
     */
    protected function _getHiddenFields()
    {
        return [
            'MODULE_ORDER_TOTAL_MOLLIE_TITLE' => [
                'configuration_value' => defined('MODULE_ORDER_TOTAL_MOLLIE_TITLE') ? MODULE_ORDER_TOTAL_MOLLIE_TITLE : $this->title,
            ],
        ];
    }

    /**
     * Install the order total module.
     */
    public function install()
    {
        $config     = array_merge($this->_configuration(), $this->_getHiddenFields());

        foreach ($config as $key => $data) {
            $setFunction = array_key_exists('set_function', $data) ? $data['set_function'] : '';
            $useFunction = array_key_exists('use_function', $data) ? $data['use_function'] : '';
            $install_query = 'INSERT INTO ' . TABLE_CONFIGURATION . ' ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) ' .
                "values ('" . $key . "', '" . xtc_db_input($data['configuration_value']) . "', '6', '" . 0 . "', '" . addslashes($setFunction) . "', '" . addslashes($useFunction) . "', now())";
            xtc_db_query($install_query);
        }
    }

    /**
     * Removes saved values from configuration table.
     */
    public function remove()
    {
        $allConfig = array_merge($this->_configuration(), $this->_getHiddenFields());
        $allKeys = array_keys($allConfig);

        $keys = '"' . implode('", "', $allKeys) . '"';

        xtc_db_query('DELETE FROM ' . TABLE_CONFIGURATION . " WHERE configuration_key IN (" . $keys . ")");
    }

}

MainFactory::load_origin_class('ot_mollie');
