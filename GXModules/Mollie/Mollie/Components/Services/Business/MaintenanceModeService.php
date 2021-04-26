<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\BusinessLogic\MaintenanceMode\MaintenanceModeService as BaseService;
use Mollie\Gambio\Utility\MollieTranslator;

/**
 * Class MaintenanceModeService
 *
 * @package Mollie\Gambio\Services\Business
 */
class MaintenanceModeService extends BaseService
{

    /**
     * @inheritDoc
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function isMaintenanceMode()
    {
        $offlineConfig = gm_get_conf('GM_SHOP_OFFLINE');

        return $offlineConfig ? $offlineConfig === 'checked' : false;
    }

    /**
     * @inheritDoc
     */
    protected function showMaintenanceModeMessage()
    {
        $messageKey = 'mollie_system_offline_message';

        $lang       = new MollieTranslator();
        $message    = $lang->translate($messageKey);

        $GLOBALS['messageStack']->add_session($message, 'warning');
    }
}
