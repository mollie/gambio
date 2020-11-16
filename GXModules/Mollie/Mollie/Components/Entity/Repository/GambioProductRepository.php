<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class ProductRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioProductRepository extends GambioBaseRepository
{
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
