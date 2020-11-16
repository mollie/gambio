<?php

namespace Mollie\Gambio\Entity;

use Mollie\Infrastructure\ORM\Configuration\EntityConfiguration;
use Mollie\Infrastructure\ORM\Configuration\IndexMap;
use Mollie\Infrastructure\ORM\Entity;

/**
 * Class StatusMapping
 *
 * @package Mollie\Gambio\Entity
 */
class StatusMapping extends Entity
{

    const CLASS_NAME = __CLASS__;

    /**
     * @var array
     */
    protected $statusMap;

    /**
     * @var string[]
     */
    protected $fields = ['id', 'statusMap'];

    /**
     * @return array
     */
    public function getStatusMap()
    {
        return $this->statusMap;
    }

    /**
     * @param array $statusMap
     */
    public function setStatusMap($statusMap)
    {
        $this->statusMap = $statusMap;
    }


    /**
     * @inheritDoc
     */
    public function getConfig()
    {
        return new EntityConfiguration(new IndexMap(), 'StatusMapping');
    }
}