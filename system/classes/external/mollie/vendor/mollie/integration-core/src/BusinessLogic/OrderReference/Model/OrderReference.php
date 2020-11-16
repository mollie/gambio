<?php

namespace Mollie\BusinessLogic\OrderReference\Model;

use Mollie\Infrastructure\ORM\Configuration\EntityConfiguration;
use Mollie\Infrastructure\ORM\Configuration\IndexMap;
use Mollie\Infrastructure\ORM\Entity;

/**
 * Class OrderReference
 *
 * @package Mollie\BusinessLogic\OrderReference\Model
 */
class OrderReference extends Entity
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    /**
     * @inheritDoc
     */
    protected $fields = array(
        'id',
        'shopReference',
        'mollieReference',
        'apiMethod',
        'payload',
    );

    /**
     * @var string
     */
    protected $shopReference;
    /**
     * @var string
     */
    protected $mollieReference;
    /**
     * @var string
     */
    protected $apiMethod;
    /**
     * @var array
     */
    protected $payload = array();

    /**
     * @inheritDoc
     */
    public function getConfig()
    {
        $map = new IndexMap();

        $map->addStringIndex('shopReference');
        $map->addStringIndex('mollieReference');

        return new EntityConfiguration($map, 'OrderReference');
    }

    /**
     * @return string
     */
    public function getShopReference()
    {
        return $this->shopReference;
    }

    /**
     * @param string $shopReference
     */
    public function setShopReference($shopReference)
    {
        $this->shopReference = (string)$shopReference;
    }

    /**
     * @return string
     */
    public function getMollieReference()
    {
        return $this->mollieReference;
    }

    /**
     * @param string $mollieReference
     */
    public function setMollieReference($mollieReference)
    {
        $this->mollieReference = (string)$mollieReference;
    }

    /**
     * @return string
     */
    public function getApiMethod()
    {
        return $this->apiMethod;
    }

    /**
     * @param string $apiMethod
     */
    public function setApiMethod($apiMethod)
    {
        $this->apiMethod = $apiMethod;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }
}