<?php

namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioConfigRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioConfigRepository extends GambioBaseRepository
{
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

    /**
     * @return string
     */
    protected function _getTableName()
    {
        return 'configuration';
    }

    /**
     * @return string
     */
    protected function _getIdentifierKey()
    {
        return '';
    }
}
