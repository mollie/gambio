<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class CountryRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class CountryRepository extends GambioBaseRepository
{

    /**
     * Returns list of enabled countries
     * @return array
     */
    public function getEnabledCountries()
    {
        return $this->queryBuilder->select()
            ->where('status', 1)
            ->get($this->_getTableName())
            ->result('array');
    }

    /**
     * @inheritDoc
     */
    protected function _getTableName()
    {
        return TABLE_COUNTRIES;
    }

    /**
     * @inheritDoc
     */
    protected function _getIdentifierKey()
    {
        return 'countries_id';
    }
}