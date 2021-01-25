<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioSpecialsRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioSpecialsRepository extends GambioBaseRepository
{
    /**
     * Counts specials records filtered by productId and datePurchased
     *
     * @param string $productId
     * @param string $datePurchased
     *h
     * @return int
     */
    public function countByProductAndDate($productId, $datePurchased)
    {
        return $this->queryBuilder->query($this->getFilterByProductAndDateQuery($productId, $datePurchased))->num_rows();
    }

    /**
     * Increase current specials quantity with the given value
     *
     * @param string $productId
     * @param int $quantity
     */
    public function increaseProductsQuantity($productId, $quantity)
    {
        $this->queryBuilder->query($this->getIncreaseQuantityQuery($productId, $quantity));
    }

    /**
     * @inheritDoc
     */
    protected function _getTableName()
    {
        return TABLE_SPECIALS;
    }

    /**
     * @inheritDoc
     */
    protected function _getIdentifierKey()
    {
        return 'specials_id';
    }

    /**
     * @param string $productId
     * @param string $datePurchased
     *
     * @return string
     */
    private function getFilterByProductAndDateQuery($productId, $datePurchased)
    {
        return 'SELECT (specials_date_added)
                FROM ' . $this->_getTableName() . "
                WHERE specials_date_added < '" . $datePurchased . "'
                AND products_id = '" . $productId . "'";
    }

    /**
     * @param int $productId
     * @param int $quantity
     *
     * @return string
     */
    private function getIncreaseQuantityQuery($productId, $quantity)
    {
        return 'UPDATE ' . TABLE_SPECIALS . '
                SET specials_quantity = specials_quantity + ' . (int)$quantity . "
                WHERE products_id = '" . (int)$productId . "'";
    }
}
