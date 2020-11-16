<?php

namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class TokenPermission
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class TokenPermission extends BaseDto
{
    /**
     * @var string
     */
    protected $resource;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var bool
     */
    protected $granted;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $raw)
    {
        $result = new static();

        $result->resource = static::getValue($raw, 'resource');
        $result->id = static::getValue($raw, 'id');
        $result->description = static::getValue($raw, 'description');
        $result->granted = static::getValue($raw, 'granted', false);

        return $result;
    }
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'description' => $this->description,
            'granted' => $this->granted,
        );
    }

    /**
     * @return string
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param string $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isGranted()
    {
        return $this->granted;
    }

    /**
     * @param bool $granted
     */
    public function setGranted($granted)
    {
        $this->granted = $granted;
    }
}
