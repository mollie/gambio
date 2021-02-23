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
     */
    protected function isMaintenanceMode()
    {
        /** @var \Gambio\Core\Configuration\ConfigurationService $configService */
        $configService = \LegacyDependencyContainer::getInstance()->get(\Gambio\Core\Configuration\ConfigurationService::class);
        $offlineConfig = $configService->find('gm_configuration/GM_SHOP_OFFLINE');

        return $offlineConfig ? $offlineConfig->value() === 'checked' : false;
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
