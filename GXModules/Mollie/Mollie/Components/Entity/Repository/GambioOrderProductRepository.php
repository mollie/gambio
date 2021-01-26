<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioOrderProductRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioOrderProductRepository extends GambioBaseRepository
{
    /**
     * Returns list of orders products filtered by order id with following details
     *  - orders_products_id
     *  - products_id
     *  - products_quantity
     *  - products_properties_combis_id
     *  - products_attributes_filename
     *  - date_purchased
     *
     * @param string $orderId
     *
     * @return array
     */
    public function getOrderProductsWithAttributes($orderId)
    {
        return $this->queryBuilder->query($this->getOrderProductsWithDetailsQuery($orderId))->result_array();
    }

    /**
     * @inheritDoc
     * @return string
     */
    protected function _getTableName()
    {
        return TABLE_ORDERS_PRODUCTS;
    }

    /**
     * @inheritDoc
     * @return string
     */
    protected function _getIdentifierKey()
    {
        return 'orders_products_id';
    }

    /**
     * @param string $orderId
     *
     * @return string
     */
    private function getOrderProductsWithDetailsQuery($orderId)
    {
        return 'SELECT DISTINCT 										
                    op.orders_products_id,
                    op.products_id,
                    op.products_quantity,
                    opp.products_properties_combis_id,
                    pad.products_attributes_filename,
                    o.date_purchased
                FROM ' . TABLE_ORDERS_PRODUCTS . ' op
                LEFT JOIN ' . TABLE_ORDERS . ' o
                    ON op.orders_id = o.orders_id
                LEFT JOIN orders_products_properties opp
                    ON opp.orders_products_id = op.orders_products_id
                LEFT JOIN ' . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . ' `opa`
                    ON opa.orders_products_id = op.orders_products_id
                LEFT JOIN ' . TABLE_PRODUCTS_ATTRIBUTES . ' pa
                    ON  op.products_id        = pa.products_id
                    AND opa.options_id        = pa.options_id
                    AND opa.options_values_id = pa.options_values_id
                LEFT JOIN ' . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " pad
                    ON pa.products_attributes_id=pad.products_attributes_id
                WHERE
                    op.orders_id = '" . xtc_db_input($orderId) . "'";
    }
}
