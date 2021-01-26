<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class ProductRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioProductRepository extends GambioBaseRepository
{
    const INCREASE_OPERATOR = '+';
    const DECREASE_OPERATOR = '-';
    const PRODUCT_QUANTITY_COLUMN = 'products_quantity';
    const ORDERED_QUANTITY_COLUMN = 'products_ordered';


    /**
     * Increases products stock by given value for specific product
     *
     * @param int $productId
     * @param int $quantity
     */
    public function increaseProductQuantity($productId, $quantity)
    {
        $this->updateQuantity($productId, $quantity, self::PRODUCT_QUANTITY_COLUMN, self::INCREASE_OPERATOR);
    }

    /**
     * Decreases ordered quantity by given value for specific product
     *
     * @param int $productId
     * @param int $quantity
     */
    public function decreaseProductOrderedQuantity($productId, $quantity)
    {
        $this->updateQuantity($productId, $quantity, self::ORDERED_QUANTITY_COLUMN, self::DECREASE_OPERATOR);
    }

    /**
     * @param int $productId
     * @param int $quantity
     * @param string $columnName
     * @param string $operator
     */
    private function updateQuantity($productId, $quantity, $columnName, $operator)
    {
        $query = 'UPDATE ' .$this->_getTableName() . '
                  SET ' . $columnName . ' = ' . $columnName . $operator . (int)$quantity . "
                  WHERE products_id = '" . (int)$productId . "'";

        $this->queryBuilder->query($query);
    }

    /**
     * @return string
     */
    protected function _getTableName()
    {
        return 'products';
    }

    /**
     * @return string
     */
    protected function _getIdentifierKey()
    {
        return 'products_id';
    }
}
