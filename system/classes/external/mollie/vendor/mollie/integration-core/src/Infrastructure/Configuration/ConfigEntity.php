<?php

namespace Mollie\Infrastructure\Configuration;

use Mollie\Infrastructure\ORM\Configuration\EntityConfiguration;
use Mollie\Infrastructure\ORM\Configuration\IndexMap;
use Mollie\Infrastructure\ORM\Entity;

/**
 * Class ConfigEntity.
 *
 * @package Mollie\Infrastructure\ORM\Entities
 */
class ConfigEntity extends Entity
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Configuration property name.
     *
     * @var string
     */
    protected $name;
    /**
     * Configuration property value.
     *
     * @var mixed
     */
    protected $value;
    /**
     * Configuration system identifier.
     *
     * @var string
     */
    protected $systemId;
    /**
     * Configuration context identifier.
     *
     * @var string
     */
    protected $context;
    /**
     * Array of field names.
     *
     * @var array
     */
    protected $fields = array('id', 'name', 'value', 'systemId', 'context');

    /**
     * Returns entity configuration object.
     *
     * @return EntityConfiguration Configuration object.
     */
    public function getConfig()
    {
        $map = new IndexMap();
        $map->addStringIndex('name')
            ->addStringIndex('systemId')
            ->addStringIndex('context');

        return new EntityConfiguration($map, 'Configuration');
    }

    /**
     * Gets configuration property name.
     *
     * @return string Configuration property name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets configuration property name.
     *
     * @param string $name Configuration property name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets Configuration property value.
     *
     * @return mixed Configuration property value.
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets Configuration property value.
     *
     * @param mixed $value Configuration property value.
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Gets Configuration system identifier.
     *
     * @return string Configuration system identifier.
     */
    public function getSystemId()
    {
        return $this->systemId;
    }

    /**
     * Sets Configuration system identifier.
     *
     * @param string $systemId Configuration system identifier.
     */
    public function setSystemId($systemId)
    {
        $this->systemId = (string)$systemId;
    }

    /**
     * Gets Configuration context identifier
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Sets Configuration context identifier
     *
     * @param string $context configuration context identifier
     */
    public function setContext($context)
    {
        $this->context = $context;
    }
}
