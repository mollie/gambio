<?php

namespace Mollie\Gambio\Mappers;

use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;

/**
 * Class OrderTotalMapper
 *
 * @package Mollie\Gambio\Mappers
 */
class OrderTotalMapper
{
    use MapperUtility;

    private static $surcharges = ['ot_mollie', 'ot_tsexcellence', 'ot_loworderfee', 'ot_gambioultra'];
    private static $discounts = ['ot_coupon', 'ot_discount', 'ot_payment', 'ot_gv'];
    private static $shipping = ['ot_shipping', 'ot_ps_fee'];

    /**
     * @var string
     */
    private $currency;

    /**
     * OrderTotalMapper constructor.
     *
     * @param string $currency
     */
    public function __construct($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return array
     */
    public function getOrderTotals(\OrderTotalCollection $orderTotals)
    {
        $totals = [];
        /** @var \StoredOrderTotal $orderTotal */
        foreach ($orderTotals as $orderTotal) {
            $value = $orderTotal->getValue();
            if (empty($value)) {
                continue;
            }

            if (in_array($orderTotal->getClass(), static::$shipping, true)) {
                $totals[] = $this->getShippingFee($orderTotal);
            }

            if (in_array($orderTotal->getClass(), static::$surcharges, true)) {
                $totals[] = $this->getSurcharge($orderTotal);
            }

            if (in_array($orderTotal->getClass(), static::$discounts, true)) {
                $totals[] = $this->getDiscounts($orderTotal);
            }
        }

        return $totals;
    }

    /**
     * @param \StoredOrderTotal $orderTotal
     *
     * @return OrderLine
     */
    public function getSurcharge(\StoredOrderTotal $orderTotal)
    {
        $total = $this->_createItem('surcharge', $orderTotal->getTitle(), $orderTotal->getValue());
        if ($orderTotal->getClass() === 'ot_mollie') {
            $this->_addMollieSurchargeTax($total);
        }

        return $total;
    }

    /**
     * @param \StoredOrderTotal $orderTotal
     *
     * @return OrderLine
     */
    public function getDiscounts(\StoredOrderTotal $orderTotal)
    {
        $discount = $orderTotal->getValue();

        if ($discount > 0) {
            $discount *= -1;
        }

        return $this->_createItem('discount', $orderTotal->getTitle(), $discount);
    }

    /**
     * @param \StoredOrderTotal $orderTotal
     */
    public function getShippingFee(\StoredOrderTotal $orderTotal)
    {
        return $this->_createItem('shipping_fee', $orderTotal->getTitle(), $orderTotal->getValue());
    }

    /**
     * @param string $type
     * @param string $name
     * @param float $price
     *
     * @return OrderLine
     */
    private function _createItem($type, $name, $price)
    {
        $item = new OrderLine();
        $name = rtrim($name, ':');
        $item->setType($type);
        $item->setQuantity(1);
        $item->setName($name);

        $item->setUnitPrice($this->_getAmount($this->currency, $price));
        $item->setTotalAmount($this->_getAmount($this->currency, $price));
        $item->setVatAmount($this->_getAmount($this->currency, 0));
        $item->setVatRate(0);

        return $item;
    }

    /**
     * @param OrderLine $line
     */
    private function _addMollieSurchargeTax(OrderLine $line)
    {
        if (defined('MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS') && $this->_otMollieEnabled()) {
            $taxRate = xtc_get_tax_rate(MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS);
            if ($taxRate) {
                $line->setVatRate($taxRate);
                $vatAmount = $line->getTotalAmount()->getAmountValue() * ($taxRate / (100 + $taxRate));
                $line->setVatAmount($this->_getAmount($this->currency, $vatAmount));
                
            }
        }
    }

    /**
     * @return bool
     */
    private function _otMollieEnabled()
    {
        return defined('MODULE_ORDER_TOTAL_MOLLIE_STATUS') ?
            strtolower(MODULE_ORDER_TOTAL_MOLLIE_STATUS) === 'true' : false;
    }
}
