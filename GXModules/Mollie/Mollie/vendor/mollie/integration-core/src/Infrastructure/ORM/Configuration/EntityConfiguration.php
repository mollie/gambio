<?php

namespace Mollie\Infrastructure\ORM\Configuration;

/**
 * Class EntityConfiguration.
 *
 * @package Mollie\Infrastructure\ORM\Configuration
 */
class EntityConfiguration
{
    /**
     * Index map.
     *
     * @var IndexMap
     */
    private $indexMap;
    /**
     * Entity type.
     *
     * @var string
     */
    private $type;

    /**
     * EntityConfiguration constructor.
     *
     * @param IndexMap $indexMap Index map object.
     * @param string $type Entity unique type.
     */
    public function __construct(IndexMap $indexMap, $type)
    {
        $this->indexMap = $indexMap;
        $this->type = $type;
    }

    /**
     * Returns index map.
     *
     * @return IndexMap Index map.
     */
    public function getIndexMap()
    {
        return $this->indexMap;
    }

    /**
     * Returns type.
     *
     * @return string Entity type.
     */
    public function getType()
    {
        return $this->type;
    }
}
