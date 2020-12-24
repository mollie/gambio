<?php


namespace Mollie\Gambio\Utility;


use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class VersionCompatibilityProvider
 *
 * @package Mollie\Gambio\Utility
 */
class VersionCompatibilityProvider
{
    /**
     * @param array $existingSelection
     * @param string $content
     */
    public function extendSelection(&$existingSelection, $content)
    {
        if ($this->isLegacyVersion()) {
            $existingSelection['description'] .= $content;
        } else {
            $existingSelection['fields'] = [
                [
                    'title' => $content,
                    'field' => '',
                ]
            ];
        }
    }

    /**
     * @return bool|int
     */
    public function isLegacyVersion()
    {
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        return version_compare($configService->getIntegrationVersion(), 'v3.9.0', 'lt');
    }
}