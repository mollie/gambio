<?php

namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class Issuer
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class Issuer extends BaseDto
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
    protected $name;
    /**
     * @var Image
     */
    protected $image;

    /**
     * @inheritDoc
     * @param array $raw
     *
     * @return Issuer
     */
    public static function fromArray(array $raw)
    {
        $issuer = new static();

        $issuer->resource = static::getValue($raw, 'resource');
        $issuer->id = static::getValue($raw, 'id');
        $issuer->name = static::getValue($raw, 'name');
        $issuer->image = Image::fromArray(static::getValue($raw, 'image', array()));

        return $issuer;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $image = $this->image ? $this->image->toArray() : null;

        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}
