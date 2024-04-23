<?php

namespace Mollie\BusinessLogic\Http\DTO;

use DateTime;

/**
 * Class Customer
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class Customer extends BaseDto
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
     * @var string
     */
    protected $mode;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var array
     */
    protected $metadata = array();
    /**
     * @var DateTime
     */
    protected $createdAt;
    /**
     * @var Link[]
     */
    protected $links = array();

    public static function fromArray(array $raw)
    {
        $customer = new static();

        $customer->resource = static::getValue($raw, 'resource');
        $customer->id = static::getValue($raw, 'id');
        $customer->name = static::getValue($raw, 'name');
        $customer->mode = static::getValue($raw, 'mode');
        $customer->email = static::getValue($raw, 'email');
        $customer->locale = static::getValue($raw, 'locale');
        $customer->metadata = (array)static::getValue($raw, 'metadata', array());
        $customer->createdAt = static::getValue($raw, 'createdAt');

        foreach ((array)static::getValue($raw, '_links', array()) as $linkKey => $linkData) {
            $customer->links[$linkKey] = Link::fromArray((array)$linkData);
        }

        return $customer;
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
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param array $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param Link[] $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function toArray()
    {
        $links = array();
        foreach ($this->links as $linkKey => $link) {
            $links[$linkKey] = $link->toArray();
        }

        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'name' => $this->name,
            'mode' => $this->mode,
            'email' => $this->email,
            'locale' => $this->locale,
            'metadata' => $this->metadata,
            'createdAt' => $this->createdAt,
            '_links' => $links,
        );
    }
}
