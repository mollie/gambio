<?php

namespace Mollie\Gambio\Mappers;

use Mollie\Gambio\Entity\StatusMapping;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class OrderStatusMapper
 *
 * @package Mollie\Gambio\Mappers
 */
class OrderStatusMapper
{

    /**
     * Returns status id
     *
     * @param string $mollieStatus
     *
     * @return int
     * @throws RepositoryNotRegisteredException
     */
    public function mapToGambioStatus($mollieStatus)
    {
        return $this->getStatusMap()[$mollieStatus];
    }


    /**
     * @return array
     * @throws RepositoryNotRegisteredException
     */
    public function getStatusMap()
    {
        $map = [
            'mollie_canceled' => 99,
            'mollie_failed'   => 99,
        ];

        $statusMapRepository = RepositoryRegistry::getRepository(StatusMapping::getClassName());
        /** @var StatusMapping $statusMapping */
        $statusMapping   = $statusMapRepository->selectOne();
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $defaultStatuses = $configService->getDefaultOrderMapping();

        if ($statusMapping === null) {
            return array_merge($map, $defaultStatuses);

        }

        $savedStatuses = $statusMapping->getStatusMap();

        foreach ($savedStatuses as $key => $value) {
            if (array_key_exists($key, $savedStatuses) && $savedStatuses[$key] !== 'none') {
                $map[$key] = $value;
            } else {
                $map[$key] = $defaultStatuses[$key];
            }
        }

        return $map;
    }
}