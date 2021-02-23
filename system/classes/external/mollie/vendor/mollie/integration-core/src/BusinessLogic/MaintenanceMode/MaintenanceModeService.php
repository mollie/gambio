<?php

namespace Mollie\BusinessLogic\MaintenanceMode;

use Mollie\BusinessLogic\BaseService;

/**
 * Class MaintenanceModeService
 *
 * @package Mollie\BusinessLogic\MaintenanceMode
 */
abstract class MaintenanceModeService extends BaseService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Check if integration system is in the maintenance mode and shows message
     */
    public function checkMaintenanceMode()
    {
        if ($this->isMaintenanceMode()) {
            $this->showMaintenanceModeMessage();
        }
    }

    /**
     * Check if integration system is in the maintenance mode
     *
     * @return bool
     */
    abstract protected function isMaintenanceMode();

    /**
     * Displays message that integration system is in maintenance mode
     */
    abstract protected function showMaintenanceModeMessage();
}
