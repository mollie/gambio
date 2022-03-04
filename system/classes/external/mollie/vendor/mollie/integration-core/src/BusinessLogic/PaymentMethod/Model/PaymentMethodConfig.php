<?php

namespace Mollie\BusinessLogic\PaymentMethod\Model;

use Mollie\BusinessLogic\Http\DTO\PaymentMethod;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethods;
use Mollie\BusinessLogic\Surcharge\SurchargeType;
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

    const ISSUER_DROPDOWN = 'dropdown';
    const ISSUER_LIST = 'list';

    const VOUCHER_CATEGORY_NONE = 'none';
    const VOUCHER_CATEGORY_GIFT = 'gift';
    const VOUCHER_CATEGORY_MEAL = 'meal';
    const VOUCHER_CATEGORY_ECO = 'eco';
    const VOUCHER_CATEGORY_CUSTOM = 'custom';

    const PRODUCT_ATTRIBUTE_DEFAULT = 'mollie_voucher_category';

    const DEFAULT_TRANSACTION_DESCRIPTION = '{orderNumber}';

    protected static $allowedSurchargeTypes = array(
        SurchargeType::NO_FEE,
        SurchargeType::FIXED_FEE,
        SurchargeType::PERCENTAGE,
        SurchargeType::FIXED_FEE_AND_PERCENTAGE
    );

    /**
     * @var string[]
     */
    protected static $apiMethodRestrictions = array(
        PaymentMethods::KlarnaPayLater => self::API_METHOD_ORDERS,
        PaymentMethods::KlarnaSliceIt => self::API_METHOD_ORDERS,
        PaymentMethods::KlarnaPayNow => self::API_METHOD_ORDERS,
        PaymentMethods::Vouchers => self::API_METHOD_ORDERS
    );

    /**
     * @var array
     */
    protected static $surchargeRestrictedPaymentMethods = array(
        PaymentMethods::KlarnaPayLater,
        PaymentMethods::KlarnaSliceIt,
        PaymentMethods::KlarnaPayNow,
    );

    /**
     * @var array
     */
    protected static $mollieComponentsSupportedMethods = array(PaymentMethods::CreditCard);

    /**
     * @var array
     */
    protected static $singleClickSupportedMethods = array(PaymentMethods::CreditCard);

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
        'surchargeType',
        'surchargeFixedAmount',
        'surchargePercentage',
        'surchargeLimit',
        'image',
        'enabled',
        'useMollieComponents',
        'useSingleClickPayment',
        'singleClickPaymentApprovalText',
        'singleClickPaymentDescription',
        'issuerListStyle',
        'daysToOrderExpire',
        'daysToPaymentExpire',
        'transactionDescription',
        'voucherCategory',
        'productAttribute',
        'sortOrder',
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
     * @var string One of SurchargeType::NO_FEE, SurchargeType::FIXED_FEE, SurchargeType::PERCENTAGE or
     * SurchargeType::FIXED_FEE_AND_PERCENTAGE
     */
    protected $surchargeType;
    /**
     * @var float
     */
    protected $surchargeFixedAmount;
    /**
     * @var float
     */
    protected $surchargePercentage;
    /**
     * @var float
     */
    protected $surchargeLimit;
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
     * @var bool
     */
    protected $useSingleClickPayment = true;

    /**
     * @var string
     */
    protected $singleClickPaymentApprovalText;

    /**
     * @var string
     */
    protected $singleClickPaymentDescription;

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
     * @var int
     */
    protected $sortOrder = 0;
    /**
     * @var string
     */
    protected $transactionDescription = self::DEFAULT_TRANSACTION_DESCRIPTION;
    /**
     * @var string
     */
    protected $voucherCategory = self::VOUCHER_CATEGORY_NONE;
    /**
     * @var string
     */
    protected $productAttribute = self::PRODUCT_ATTRIBUTE_DEFAULT;

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
        return array_key_exists($this->getMollieId(), static::$apiMethodRestrictions);
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
    public function isSingleClickPaymentSupported()
    {
        return in_array($this->getMollieId(), static::$singleClickSupportedMethods, true);
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
            $apiMethod !== static::$apiMethodRestrictions[$this->getMollieId()]
        ) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid payment method api value %s. Payment method %s supports only %s API method',
                    $apiMethod,
                    $this->getMollieId(),
                    static::$apiMethodRestrictions[$this->getMollieId()]
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
     * @return string
     */
    public function getSurchargeType()
    {
        return $this->surchargeType ?: SurchargeType::NO_FEE;
    }

    /**
     * @param string $surchargeType
     */
    public function setSurchargeType($surchargeType)
    {
        if (!in_array($surchargeType, static::$allowedSurchargeTypes, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid surcharge type value %s. Surcharge type can be one of (%s) values',
                    $surchargeType,
                    implode(', ', static::$allowedSurchargeTypes)
                )
            );
        }

        $this->surchargeType = $surchargeType;
    }

    /**
     * @return float
     */
    public function getSurchargeFixedAmount()
    {
        return $this->surchargeFixedAmount;
    }

    /**
     * @param float $surchargeFixedAmount
     */
    public function setSurchargeFixedAmount($surchargeFixedAmount)
    {
        $this->surchargeFixedAmount = $surchargeFixedAmount;
    }

    /**
     * @return float
     */
    public function getSurchargePercentage()
    {
        return $this->surchargePercentage;
    }

    /**
     * @param float $surchargePercentage
     */
    public function setSurchargePercentage($surchargePercentage)
    {
        $this->surchargePercentage = $surchargePercentage;
    }

    /**
     * @return float
     */
    public function getSurchargeLimit()
    {
        return $this->surchargeLimit;
    }

    /**
     * @param float $surchargeLimit
     */
    public function setSurchargeLimit($surchargeLimit)
    {
        $this->surchargeLimit = $surchargeLimit;
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
     * @return bool
     */
    public function useSingleClickPayment()
    {
        return $this->useSingleClickPayment;
    }

    /**
     * @param bool $useSingleClickPayment
     */
    public function setUseSingleClickPayment($useSingleClickPayment)
    {
        $this->useSingleClickPayment = $useSingleClickPayment;
    }

    /**
     * @return string
     */
    public function getSingleClickPaymentApprovalText()
    {
        return $this->singleClickPaymentApprovalText;
    }

    /**
     * @param string $singleClickPaymentApprovalText
     */
    public function setSingleClickPaymentApprovalText($singleClickPaymentApprovalText)
    {
        $this->singleClickPaymentApprovalText = $singleClickPaymentApprovalText;
    }

    /**
     * @return string
     */
    public function getSingleClickPaymentDescription()
    {
        return $this->singleClickPaymentDescription;
    }

    /**
     * @param string $singleClickPaymentDescription
     */
    public function setSingleClickPaymentDescription($singleClickPaymentDescription)
    {
        $this->singleClickPaymentDescription = $singleClickPaymentDescription;
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
        return $this->transactionDescription ?: static::DEFAULT_TRANSACTION_DESCRIPTION;
    }

    /**
     * @param string $transactionDescription
     */
    public function setTransactionDescription($transactionDescription)
    {
        $this->transactionDescription = $transactionDescription;
    }

    /**
     * @return string
     */
    public function getVoucherCategory()
    {
        return $this->voucherCategory ?: static::VOUCHER_CATEGORY_NONE;
    }

    /**
     * @param string $voucherCategory
     */
    public function setVoucherCategory($voucherCategory)
    {
        $this->voucherCategory = $voucherCategory;
    }

    /**
     * @return string
     */
    public function getProductAttribute()
    {
        return $this->productAttribute ?: static::PRODUCT_ATTRIBUTE_DEFAULT;
    }

    /**
     * @param string $productAttribute
     */
    public function setProductAttribute($productAttribute)
    {
        $this->productAttribute = $productAttribute;
    }

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param mixed $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }
}
