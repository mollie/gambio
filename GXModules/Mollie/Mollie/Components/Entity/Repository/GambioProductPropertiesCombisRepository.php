<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class ProductPropertiesCombisRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioProductPropertiesCombisRepository extends GambioBaseRepository
{

    /**
     * Returns row count specified by productId
     *
     * @param int $productId
     *
     * @return int
     */
    public function countByProductId($productId)
    {
        return $this->queryBuilder
            ->select('products_properties_combis_id')
            ->from($this->_getTableName())
            ->where('products_id', $productId)
            ->get()
            ->num_rows();
    }

    /**
     * Increases combi quantity by productId
     *
     * @param int $productId
     * @param int $productsPropertiesCombisId
     * @param int $quantity
     */
    public function increaseCombiQuantity($productId, $productsPropertiesCombisId, $quantity)
    {
        $this->queryBuilder->query($this->getUpdateProductPropertiesCombiesQuery($productId, $productsPropertiesCombisId, $quantity));
    }

    /**
     * @inheritDoc
     */
    protected function _getTableName()
    {
        return 'products_properties_combis';
    }

    /**
     * @inheritDoc
     */
    protected function _getIdentifierKey()
    {
        return 'products_properties_combis_values_id';
    }

    /**
     * @param int $productId
     * @param int $productsPropertiesCombisId
     * @param int $quantity
     *
     * @return string
     */
    private function getUpdateProductPropertiesCombiesQuery($productId, $productsPropertiesCombisId, $quantity)
    {
        return 'UPDATE ' . $this->_getTableName() . '
                SET combi_quantity = combi_quantity + ' . (int)$quantity . "
                WHERE products_properties_combis_id = '" . (int)$productsPropertiesCombisId . "' 
                AND products_id = '" . (int)$productId . "'";
    }
}
