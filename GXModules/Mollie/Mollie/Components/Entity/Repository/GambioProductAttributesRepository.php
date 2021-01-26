<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioProductPropertiesRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioProductAttributesRepository extends GambioBaseRepository
{
    /**
     * Returns product attributes list filtered by order id and order product id in format:
     *  - products_options
     *  - products_options_values
     *
     * @param int $orderId
     * @param int $ordersProductsId
     *
     * @return array
     */
    public function getOrdersAttributes($orderId, $ordersProductsId)
    {
        return $this->queryBuilder
            ->select('products_options, products_options_values')
            ->where('orders_id', $orderId, true)
            ->where('orders_products_id', $ordersProductsId, true)
            ->get($this->_getTableName())
            ->result('array');
    }

    /**
     * @param int $productsId
     * @param string $productsOptions
     * @param string $productsOptionsValues
     *
     * @return mixed
     */
    public function getProductAttributesId($productsId, $productsOptions, $productsOptionsValues)
    {
        $query = "SELECT pa.products_attributes_id
                  FROM products_options_values pov,
                       products_options po,
                       products_attributes pa
                  WHERE po.products_options_name = '" . addslashes($productsOptions) . "'
                  AND po.products_options_id = pa.options_id
                  AND pov.products_options_values_id = pa.options_values_id
                  AND pov.products_options_values_name = '" . addslashes($productsOptionsValues) . "'
                  AND pa.products_id = '" . $productsId . "'
                  LIMIT 1";

        $result = $this->queryBuilder->query($query)->result_array();

        return !empty($result[0]['products_attributes_id']) ? $result[0]['products_attributes_id'] : null;
    }

    /**
     * Increases attributes stock
     *
     * @param int $productAttributesId
     * @param int $quantity
     */
    public function increaseAttributesStock($productAttributesId, $quantity)
    {
        $query = 'UPDATE products_attributes
                  SET attributes_stock = attributes_stock + ' . (int)$quantity . "
                  WHERE products_attributes_id = '" . (int)$productAttributesId . "'";

        $this->queryBuilder->query($query);
    }

    /**
     * @inheritDoc
     */
    protected function _getTableName()
    {
        return TABLE_ORDERS_PRODUCTS_ATTRIBUTES;
    }

    /**
     * @inheritDoc
     */
    protected function _getIdentifierKey()
    {
        return 'products_attributes_id';
    }
}
