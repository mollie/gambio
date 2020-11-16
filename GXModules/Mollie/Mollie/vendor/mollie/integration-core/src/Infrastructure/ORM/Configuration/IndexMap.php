<?php

namespace Mollie\Infrastructure\ORM\Configuration;

/**
 * Represents a map of all columns that are indexed.
 *
 * @package Mollie\Infrastructure\ORM\Configuration
 */
class IndexMap
{
    /**
     * Array of indexed columns.
     *
     * @var Index[]
     */
    private $indexes = array();

    /**
     * Adds boolean index.
     *
     * @param string $name Column name for index.
     *
     * @return self This instance for chaining.
     */
    public function addBooleanIndex($name)
    {
        return $this->addIndex(new Index(Index::BOOLEAN, $name));
    }

    /**
     * Adds datetime index.
     *
     * @param string $name Column name for index.
     *
     * @return self This instance for chaining.
     */
    public function addDateTimeIndex($name)
    {
        return $this->addIndex(new Index(Index::DATETIME, $name));
    }

    /**
     * Adds double index.
     *
     * @param string $name Column name for index.
     *
     * @return self This instance for chaining.
     */
    public function addDoubleIndex($name)
    {
        return $this->addIndex(new Index(Index::DOUBLE, $name));
    }

    /**
     * Adds integer index.
     *
     * @param string $name Column name for index.
     *
     * @return self This instance for chaining.
     */
    public function addIntegerIndex($name)
    {
        return $this->addIndex(new Index(Index::INTEGER, $name));
    }

    /**
     * Adds string index.
     *
     * @param string $name Column name for index.
     *
     * @return self This instance for chaining.
     */
    public function addStringIndex($name)
    {
        return $this->addIndex(new Index(Index::STRING, $name));
    }

    /**
     * Returns array of indexes.
     *
     * @return Index[] Array of indexes.
     */
    public function getIndexes()
    {
        return $this->indexes;
    }

    /**
     * Adds index to map.
     *
     * @param Index $index Index to be added.
     *
     * @return self This instance for chaining.
     */
    protected function addIndex(Index $index)
    {
        $this->indexes[$index->getProperty()] = $index;

        return $this;
    }
}
