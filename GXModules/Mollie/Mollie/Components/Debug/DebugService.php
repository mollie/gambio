<?php


namespace Mollie\Gambio\Debug;

use Mollie\BusinessLogic\OrderReference\Model\OrderReference;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class DebugService
 *
 * @package Mollie\Gambio\Debug
 */
class DebugService
{
    /**
     * Returns configuration fields and all existing references
     *
     * @return array
     * @throws RepositoryNotRegisteredException
     */
    public function getDebugInfo()
    {
        return [
            'isDebugModeEnabled' => $this->getConfigService()->isDebugModeEnabled(),
            'references'         => $this->_getAllReferences(),
        ];
    }

    /**
     * Updates configuration options from given input
     *
     * @param array $input
     */
    public function updateConfig(array $input)
    {
        if (array_key_exists('debug_mode', $input)) {
            $this->getConfigService()->setDebugModeEnabled($input['debug_mode']);
        }
    }

    /**
     * @return array
     * @throws RepositoryNotRegisteredException
     */
    private function _getAllReferences()
    {
        $formattedReferences = [];
        /** @var OrderReference[] $references */
        $references = RepositoryRegistry::getRepository(OrderReference::getClassName())->select();
        foreach ($references as $reference) {
            $formattedReferences[] = $reference->toArray();
        }

        return $formattedReferences;
    }

    /**
     * @return ConfigurationService
     */
    private function getConfigService()
    {
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);

        return $configService;
    }
}
