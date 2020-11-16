<?php


namespace Mollie\Gambio\Utility;

use GmConfigurationServiceInterface;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class MollieModuleChecker
 *
 * @package Mollie\Gambio\Utility
 */
class MollieModuleChecker
{
    const MODULE_KEY = 'MODULE_CENTER_MOLLIE_INSTALLED';

    /**
     * Check if plugin is installed and if is connected with to mollie
     *
     * @return bool
     */
    public static function isConnected()
    {
        if (!static::isInstalled()) {
            return false;
        }

        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $apiKey = $configService->getAuthorizationToken();

        return !empty($apiKey);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public static function isInstalled()
    {
        $dbName = DB_DATABASE;
        $tableName = \MollieModuleCenterModule::ENTITY_TABLE;

        $sql = "SELECT * 
                FROM information_schema.tables
                WHERE TABLE_SCHEMA = '". $dbName ."' AND TABLE_NAME = '". $tableName ."'
                LIMIT 1;";

        $res = xtc_db_num_rows(xtc_db_query($sql));

        return !empty($res);
    }
}