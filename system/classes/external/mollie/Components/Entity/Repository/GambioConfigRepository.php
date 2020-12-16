<?php

namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioConfigRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioConfigRepository extends GambioBaseRepository
{
    const TABLE_NAME = 'configuration';

    /**
     * @return mixed
     */
    public function getMollieConfiguration()
    {
        return $this->queryBuilder->select('configuration_key, configuration_value')
            ->where('configuration_key LIKE', 'MODULE_PAYMENT_MOLLIE_%')
            ->get($this->_getTableName())
            ->result('array');
    }

    public function insert($values)
    {
        $this->queryBuilder->insert(self::TABLE_NAME, $values, true);
    }

    /**
     * @return string
     */
    protected function _getTableName()
    {
        return self::TABLE_NAME;
    }

    /**
     * @return string
     */
    protected function _getIdentifierKey()
    {
        return '';
    }
}
