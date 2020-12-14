<?php

namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class PaymentMethod
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class PaymentMethod extends BaseDto
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
     * @var Image
     */
    protected $image;
    /**
     * @var Issuer[]
     */
    protected $issuers = array();

    /**
     * @inheritDoc
     */
    public static function fromArray(array $raw)
    {
        $result = new static();

        $result->resource = static::getValue($raw, 'resource');
        $result->id = static::getValue($raw, 'id');
        $result->description = static::getValue($raw, 'description');
        $result->image = Image::fromArray(static::getValue($raw, 'image', array()));
        $result->issuers = !empty($raw['issuers']) ? Issuer::fromArrayBatch($raw['issuers']) : array();

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $issuers = array();
        foreach ($this->issuers as $issuer) {
            $issuers[] = $issuer->toArray();
        }

        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'description' => $this->description,
            'image' => $this->image->toArray(),
            'issuers' => $issuers,
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

    /**
     * @return Issuer[]
     */
    public function getIssuers()
    {
        return $this->issuers;
    }

    /**
     * @param Issuer[] $issuers
     */
    public function setIssuers($issuers)
    {
        $this->issuers = $issuers;
    }
}
