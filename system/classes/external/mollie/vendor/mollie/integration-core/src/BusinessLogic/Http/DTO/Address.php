<?php

namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class Address
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class Address extends BaseDto
{

    /**
     * @var string
     */
    protected $organizationName;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $givenName;
    /**
     * @var string
     */
    protected $familyName;
    /**
     * @var string
     */
    protected $email;
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var string
     */
    protected $streetAndNumber;
    /**
     * @var string
     */
    protected $streetAdditional;
    /**
     * @var string
     */
    protected $postalCode;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $region;
    /**
     * @var string
     */
    protected $country;

    /**
     * @param array $raw
     *
     * @return Address
     */
    public static function fromArray(array $raw)
    {
        $address = new static();
        $address->givenName = static::getValue($raw, 'givenName');
        $address->familyName = static::getValue($raw, 'familyName');
        $address->streetAndNumber = static::getValue($raw, 'streetAndNumber');
        $address->city = static::getValue($raw, 'city');
        $address->postalCode = static::getValue($raw, 'postalCode');
        $address->country = static::getValue($raw, 'country');
        $address->postalCode = static::getValue($raw, 'postalCode');
        $address->email = static::getValue($raw, 'email');
        $address->organizationName = static::getValue($raw, 'organizationName', null);
        $address->title = static::getValue($raw, 'title', null);
        $address->phone = static::getValue($raw, 'phone', null);
        $address->region = static::getValue($raw, 'region', null);
        $address->streetAdditional = static::getValue($raw, 'streetAdditional', null);

        return $address;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'givenName' => $this->givenName,
            'familyName' => $this->familyName,
            'streetAndNumber' => $this->streetAndNumber,
            'city' => $this->city,
            'postalCode' => $this->postalCode,
            'country' => $this->country,
            'email' => $this->email,
            'organizationName' => $this->organizationName,
            'title' => $this->title,
            'phone' => $this->phone,
            'region' => $this->region,
            'streetAdditional' => $this->streetAdditional
        );
    }

    /**
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param string $organizationName
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getGivenName()
    {
        return $this->givenName;
    }

    /**
     * @param string $givenName
     */
    public function setGivenName($givenName)
    {
        $this->givenName = $givenName;
    }

    /**
     * @return string
     */
    public function getFamilyName()
    {
        return $this->familyName;
    }

    /**
     * @param string $familyName
     */
    public function setFamilyName($familyName)
    {
        $this->familyName = $familyName;
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
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getStreetAndNumber()
    {
        return $this->streetAndNumber;
    }

    /**
     * @param string $streetAndNumber
     */
    public function setStreetAndNumber($streetAndNumber)
    {
        $this->streetAndNumber = $streetAndNumber;
    }

    /**
     * @return string
     */
    public function getStreetAdditional()
    {
        return $this->streetAdditional;
    }

    /**
     * @param string $streetAdditional
     */
    public function setStreetAdditional($streetAdditional)
    {
        $this->streetAdditional = $streetAdditional;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
