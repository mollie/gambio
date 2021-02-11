<?php


namespace Mollie\BusinessLogic\PaymentMethod\DTO;

use Mollie\BusinessLogic\Http\DTO\BaseDto;

/**
 * Class DescriptionParameters
 *
 * @package Mollie\BusinessLogic\PaymentMethod\DTO
 */
class DescriptionParameters extends BaseDto
{

    /**
     * @var string
     */
    protected $orderNumber;
    /**
     * @var string
     */
    protected $storeName;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $company;
    /**
     * @var string
     */
    protected $cartNumber;

    /**
     * DescriptionParameters constructor.
     *
     * @param string $orderNumber
     * @param string $storeName
     * @param string $firstName
     * @param string $lastName
     * @param string $company
     * @param string $cartNumber
     */
    public function __construct(
        $orderNumber,
        $storeName,
        $firstName,
        $lastName,
        $company,
        $cartNumber
    ) {
        $this->orderNumber = $orderNumber;
        $this->storeName = $storeName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->company = $company;
        $this->cartNumber = $cartNumber;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            '{orderNumber}' => $this->orderNumber,
            '{storeName}' => $this->storeName,
            '{firstName}' => $this->firstName,
            '{lastName}' => $this->lastName,
            '{company}' => $this->company,
            '{cartNumber}' => $this->cartNumber,
        );
    }

    /**
     * @param array $raw
     *
     * @return DescriptionParameters|static
     */
    public static function fromArray(array $raw)
    {
        return new static(
            static::getValue($raw, 'orderNumber'),
            static::getValue($raw, 'storeName'),
            static::getValue($raw, 'firstName'),
            static::getValue($raw, 'lastName'),
            static::getValue($raw, 'company'),
            static::getValue($raw, 'cartNumber')
        );
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return string
     */
    public function getCartNumber()
    {
        return $this->cartNumber;
    }
}