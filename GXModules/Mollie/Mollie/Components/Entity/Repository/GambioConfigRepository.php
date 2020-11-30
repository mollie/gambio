<?php

namespace Mollie\Gambio\Entity\Repository;

use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class GambioConfigRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioConfigRepository extends GambioBaseRepository
{
    const KEY_ALIAS = 'configuration_key';
    const VALUE_ALIAS = 'configuration_value';


    /**
     * @return mixed
     */
    public function getMollieConfiguration()
    {
        return $this->queryBuilder->select($this->getSelectQuery())
            ->where('`key` LIKE', 'configuration/MODULE_PAYMENT_MOLLIE_%', true)
            ->get($this->_getTableName())
            ->result('array');
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getByKey($key)
    {
        return $this->queryBuilder->select($this->getSelectQuery())
            ->where('`key`', $key, true)
            ->get($this->_getTableName())
            ->result('array');
    }

    /**
     * @return string
     */
    protected function _getTableName()
    {
        return 'gx_configurations';
    }

    /**
     * @return string
     */
    protected function _getIdentifierKey()
    {
        return '';
    }

    protected function _isLegacyVersion()
    {
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        return version_compare('v4.1.0', $configService->getIntegrationVersion(), 'gt');
    }

    /**
     * @return string
     */
    protected function getSelectQuery()
    {
        return '`key` as ' . self::KEY_ALIAS . ', `value` as '. self::VALUE_ALIAS;
    }
}
