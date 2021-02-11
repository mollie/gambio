<?php

namespace Mollie\BusinessLogic\PaymentMethod\Model;

use Mollie\BusinessLogic\Http\DTO\PaymentMethod;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethods;
use Mollie\Infrastructure\ORM\Configuration\EntityConfiguration;
use Mollie\Infrastructure\ORM\Configuration\IndexMap;
use Mollie\Infrastructure\ORM\Entity;

/**
 * Class PaymentMethodConfig
 *
 * @package Mollie\BusinessLogic\PaymentMethod\Model
 */
class PaymentMethodConfig extends Entity
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;

    const API_METHOD_PAYMENT = 'payment_api';
    const API_METHOD_ORDERS = 'orders_api';

    const ISSUER_LIST = 'list';
    const ISSUER_DROPDOWN = 'dropdown';

    /**
     * @var string[]
     */
    protected static $adiMethodRestrictions = array(
        PaymentMethods::KlarnaPayLater => self::API_METHOD_ORDERS,
        PaymentMethods::KlarnaSliceIt => self::API_METHOD_ORDERS,
    );

    /**
     * @var array
     */
    protected static $surchargeRestrictedPaymentMethods = array(PaymentMethods::KlarnaPayLater, PaymentMethods::KlarnaSliceIt);

    /**
     * @var array
     */
    protected static $mollieComponentsSupportedMethods = array(PaymentMethods::CreditCard);

    /**
     * @var array
     */
    protected static $mollieIssuerSupportedMethods = array(
        PaymentMethods::iDEAL,
        PaymentMethods::GiftCard,
        PaymentMethods::KBC,
    );

    /**
     * @inheritDoc
     */
    protected $fields = array(
        'id',
        'profileId',
        'name',
        'description',
        'apiMethod',
        'surcharge',
        'image',
        'enabled',
        'useMollieComponents',
        'issuerListStyle',
        'daysToOrderExpire',
        'daysToPaymentExpire',
        'transactionDescription',
    );

    /**
     * @var string
     */
    protected $profileId;
    /**
     * @var string
     */
    protected  $name;
    /**
     * @var string
     */
    protected  $description;
    /**
     * @var string One of PaymentMethodConfig::API_METHOD_PAYMENT or PaymentMethodConfig::API_METHOD_ORDERS
     */
    protected  $apiMethod;
    /**
     * @var float
     */
    protected  $surcharge;
    /**
     * @var null|string
     */
    protected  $image;
    /**
     * @var bool
     */
    protected  $enabled = false;
    /**
     * @var PaymentMethod
     */
    protected  $originalAPIConfig;

    /**
     * @var bool
     */
    protected $useMollieComponents = true;
    /**
     * @var string
     */
    protected $issuerListStyle = self::ISSUER_LIST;
    /**
     * @var int
     */
    protected $daysToOrderExpire;
    /**
     * @var int
     */
    protected $daysToPaymentExpire;
    /**
     * @var string
     */
    protected $transactionDescription = '{orderNumber}';

    /**
     * @inheritDoc
     */
    public function getConfig()
    {
        $map = new IndexMap();

        $map->addStringIndex('profileId');
        $map->addStringIndex('mollieId');

        return new EntityConfiguration($map, 'PaymentMethodConfig');
    }

    /**
     * @inheritDoc
     */
    public function inflate(array $data)
    {
        parent::inflate($data);

        if (!empty($data['originalAPIConfig'])) {
            $this->originalAPIConfig = PaymentMethod::fromArray($data['originalAPIConfig']);
        }
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $data = parent::toArray();
        $data['originalAPIConfig'] = $this->originalAPIConfig->toArray();

        return $data;
    }

    /**
     * @return bool
     */
    public function isSurchargeRestricted()
    {
        return in_array($this->getMollieId(), static::$surchargeRestrictedPaymentMethods, true);
    }

    /**
     * @return bool
     */
    public function isApiMethodRestricted()
    {
        return array_key_exists($this->getMollieId(), static::$adiMethodRestrictions);
    }

    /**
     * @return bool
     */
    public function isMollieComponentsSupported()
    {
        return in_array($this->getMollieId(), static::$mollieComponentsSupportedMethods, true);
    }

    /**
     * @return bool
     */
    public function isIssuerListSupported()
    {
        return in_array($this->getMollieId(), static::$mollieIssuerSupportedMethods, true);
    }

    /**
     * @return string
     */
    public function getMollieId()
    {
        return $this->originalAPIConfig->getId();
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return $this->profileId;
    }

    /**
     * @param string $profileId
     */
    public function setProfileId($profileId)
    {
        $this->profileId = $profileId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name ?: $this->originalAPIConfig->getId();
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
    public function getDescription()
    {
        return $this->description ?: $this->originalAPIConfig->getDescription();
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getApiMethod()
    {
        return $this->apiMethod ?: self::API_METHOD_ORDERS;
    }

    /**
     * @param string $apiMethod
     */
    public function setApiMethod($apiMethod)
    {
        $allowedMethods = array(self::API_METHOD_PAYMENT, self::API_METHOD_ORDERS);
        if (!in_array($apiMethod, $allowedMethods, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid payment method api value %s. API method can be one of (%s) values',
                    $apiMethod,
                    implode(', ', $allowedMethods)
                )
            );
        }

        if (
            $this->isApiMethodRestricted() &&
            $apiMethod !== static::$adiMethodRestrictions[$this->getMollieId()]
        ) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid payment method api value %s. Payment method %s supports only %s API method',
                    $apiMethod,
                    $this->getMollieId(),
                    static::$adiMethodRestrictions[$this->getMollieId()]
                )
            );
        }

        $this->apiMethod = $apiMethod;
    }

    /**
     * @return string|null
     */
    public function getImage()
    {
        return $this->hasCustomImage() ? $this->image : $this->originalAPIConfig->getImage()->getSize2x();
    }

    /**
     * @param string|null $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return bool
     */
    public function hasCustomImage()
    {
        return (bool)$this->image;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return PaymentMethod
     */
    public function getOriginalAPIConfig()
    {
        return $this->originalAPIConfig;
    }

    /**
     * @param PaymentMethod $originalAPIConfig
     */
    public function setOriginalAPIConfig($originalAPIConfig)
    {
        $this->originalAPIConfig = $originalAPIConfig;
    }

    /**
     * @return float
     */
    public function getSurcharge()
    {
        return $this->surcharge;
    }

    /**
     * @param float $surcharge
     */
    public function setSurcharge($surcharge)
    {
        $this->surcharge = $surcharge;
    }

    /**
     * @return bool
     */
    public function useMollieComponents()
    {
        return $this->useMollieComponents;
    }

    /**
     * @param bool $useMollieComponents
     */
    public function setUseMollieComponents($useMollieComponents)
    {
        $this->useMollieComponents = $useMollieComponents;
    }

    /**
     * @return string
     */
    public function getIssuerListStyle()
    {
        return $this->issuerListStyle;
    }

    /**
     * @param string $issuerListStyle
     */
    public function setIssuerListStyle($issuerListStyle)
    {
        $this->issuerListStyle = $issuerListStyle;
    }

    /**
     * @return int
     */
    public function getDaysToOrderExpire()
    {
        return $this->daysToOrderExpire;
    }

    /**
     * @param int $daysToOrderExpire
     */
    public function setDaysToOrderExpire($daysToOrderExpire)
    {
        $this->daysToOrderExpire = $daysToOrderExpire;
    }

    /**
     * @return int
     */
    public function getDaysToPaymentExpire()
    {
        return $this->daysToPaymentExpire;
    }

    /**
     * @param int $daysToPaymentExpire
     */
    public function setDaysToPaymentExpire($daysToPaymentExpire)
    {
        $this->daysToPaymentExpire = $daysToPaymentExpire;
    }

    /**
     * @return string
     */
    public function getTransactionDescription()
    {
        return $this->transactionDescription;
    }

    /**
     * @param string $transactionDescription
     */
    public function setTransactionDescription($transactionDescription)
    {
        $this->transactionDescription = $transactionDescription;
    }
}
