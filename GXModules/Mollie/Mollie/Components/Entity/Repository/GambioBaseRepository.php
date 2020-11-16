<?php

namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioBaseRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
abstract class GambioBaseRepository
{
    protected $queryBuilder;

    /**
     * GambioBaseRepository constructor.
     */
    public function __construct()
    {
        $this->queryBuilder = \StaticGXCoreLoader::getDatabaseQueryBuilder();
    }

    /**
     * @param $id
     *
     * @return array|null
     */
    public function getById($id)
    {
        $results = $this->queryBuilder->select()
            ->where($this->_getIdentifierKey(), $id)
            ->get($this->_getTableName())
            ->result('array');

        return array_key_exists(0, $results) ? $results[0] : null;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->queryBuilder->select()
            ->get($this->_getTableName())
            ->result('array');
    }

    /**
     * Returns repository table name
     *
     * @return string
     */
    abstract protected function _getTableName();

    /**
     * Returns id key for the table name
     *
     * @return string
     */
    abstract protected function _getIdentifierKey();

}