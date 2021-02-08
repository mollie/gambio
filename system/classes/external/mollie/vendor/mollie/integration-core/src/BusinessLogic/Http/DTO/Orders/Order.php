<?php

namespace Mollie\BusinessLogic\Http\DTO\Orders;

use Mollie\BusinessLogic\Http\DTO\Address;
use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\BaseDto;
use Mollie\BusinessLogic\Http\DTO\Link;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;
use Mollie\BusinessLogic\Http\DTO\SupportedLocale;

/**
 * Class Order
 *
 * @package Mollie\BusinessLogic\Http\DTO\Orders
 */
class Order extends BaseDto
{
    const MOLLIE_DATE_FORMAT = 'Y-m-d';

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
    protected $profileId;
    /**
     * @var string[]
     */
    protected $method;
    /**
     * @var Amount
     */
    protected $amount;
    /**
     * @var Amount
     */
    protected $amountCaptured;
    /**
     * @var Amount
     */
    protected $amountRefunded;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var bool
     */
    protected $isCancelable;
    /**
     * @var array
     */
    protected $metadata = array();
    /**
     * @var \DateTime
     */
    protected $createdAt;
    /**
     * @var \DateTime
     */
    protected $expiresAt;
    /**
     * @var \DateTime
     */
    protected $expiredAt;
    /**
     * @var \DateTime
     */
    protected $paidAt;
    /**
     * @var \DateTime
     */
    protected $authorizedAt;
    /**
     * @var \DateTime
     */
    protected $canceledAt;
    /**
     * @var \DateTime
     */
    protected $completedAt;
    /**
     * @var string
     */
    protected $mode;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var Address
     */
    protected $billingAddress;
    /**
     * @var bool
     */
    protected $shopperCountryMustMatchBillingCountry;
    /**
     * @var \DateTime
     */
    protected $consumerDateOfBirth;
    /**
     * @var string
     */
    protected $orderNumber;
    /**
     * @var Address
     */
    protected $shippingAddress;
    /**
     * @var string
     */
    protected $redirectUrl;
    /**
     * @var string
     */
    protected $webhookUrl;
    /**
     * @var Payment
     */
    protected $payment;
    /**
     * @var OrderLine[]
     */
    protected $lines = array();
    /**
     * @var array
     */
    protected $embedded = array(
        'payments' => array(),
        'refunds' => array(),
    );
    /**
     * @var Link[]
     */
    protected $links = array();

    /**
     * @param array $raw
     *
     * @return Order
     */
    public static function fromArray(array $raw)
    {
        $order = new static();
        $order->resource = static::getValue($raw, 'resource');
        $order->id = static::getValue($raw, 'id');
        $order->profileId = static::getValue($raw, 'profileId');
        $method = static::getValue($raw, 'method', array());
        $method = is_array($method) ? $method : array($method);
        $order->method = $method;
        $order->amount = Amount::fromArray(static::getValue($raw, 'amount', array()));
        $order->amountCaptured = Amount::fromArray(static::getValue($raw, 'amountCaptured', array()));
        $order->amountRefunded = Amount::fromArray(static::getValue($raw, 'amountRefunded', array()));
        $order->status = static::getValue($raw, 'status');
        $order->isCancelable = static::getValue($raw, 'isCancelable', true);
        $order->metadata = static::getValue($raw, 'metadata', array());
        $order->createdAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'createdAt'));
        $order->expiresAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'expiresAt'));
        $order->expiredAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'expiredAt'));
        $order->paidAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'paidAt'));
        $order->authorizedAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'authorizedAt'));
        $order->canceledAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'canceledAt'));
        $order->completedAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'completedAt'));
        $order->mode = static::getValue($raw, 'mode');
        $order->setLocale(static::getValue($raw, 'locale'));
        $order->billingAddress = Address::fromArray(static::getValue($raw, 'billingAddress', array()));
        $order->shopperCountryMustMatchBillingCountry = static::getValue($raw, 'shopperCountryMustMatchBillingCountry');
        $order->consumerDateOfBirth = \DateTime::createFromFormat(self::MOLLIE_DATE_FORMAT, static::getValue($raw, 'consumerDateOfBirth'));
        $order->orderNumber = static::getValue($raw, 'orderNumber');
        $shippingAddress = static::getValue($raw, 'shippingAddress', array());
        $order->shippingAddress = !empty($shippingAddress) ? Address::fromArray($shippingAddress) : null;
        $order->redirectUrl = static::getValue($raw, 'redirectUrl');
        $order->webhookUrl = static::getValue($raw, 'webhookUrl');
        $order->cardToken = static::getValue($raw, 'cardToken');
        $order->setLines(OrderLine::fromArrayBatch(static::getValue($raw, 'lines', array())));
        if (array_key_exists('_embedded', $raw)) {
            $order->embedded['payments'] = Payment::fromArrayBatch(static::getValue($raw['_embedded'], 'payments', array()));
            $order->embedded['refunds'] = Refund::fromArrayBatch(static::getValue($raw['_embedded'], 'refunds', array()));
        }

        foreach (static::getValue($raw, '_links', array()) as $linkKey => $linkData) {
            $order->links[$linkKey] = Link::fromArray($linkData);
        }

        if (!empty($raw['payment'])) {
            $order->payment = Payment::fromArray($raw['payment']);
        }

        return $order;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $embedded = array(
            'payments' => array(),
            'refunds' => array(),
        );

        /** @var Payment $payment */
        foreach ($this->embedded['payments'] as $payment) {
            $embedded['payments'][] = $payment->toArray();
        }

        /** @var Refund $refund */
        foreach ($this->embedded['refunds'] as $refund) {
            $embedded['refunds'][] = $refund->toArray();
        }

        $lines = array();
        foreach ($this->lines as $orderLine) {
            $lines[] = $orderLine->toArray();
        }

        $links = array();
        foreach ($this->links as $linkKey => $link) {
            $links[$linkKey] = $link->toArray();
        }

        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'profileId' => $this->profileId,
            'method' => $this->method,
            'amount' => $this->amount->toArray(),
            'amountRefunded' => $this->amountRefunded->toArray(),
            'amountCaptured' => $this->amountCaptured->toArray(),
            'status' => $this->status,
            'isCancelable' => $this->isCancelable,
            'metadata' => $this->metadata,
            'createdAt' => $this->createdAt ? $this->createdAt->format(DATE_ATOM) : null,
            'expiresAt' => $this->expiresAt ? $this->expiresAt->format(DATE_ATOM) : null,
            'expiredAt' => $this->expiredAt ? $this->expiredAt->format(DATE_ATOM) : null,
            'paidAt' => $this->paidAt ? $this->paidAt->format(DATE_ATOM) : null,
            'authorizedAt' => $this->authorizedAt ? $this->authorizedAt->format(DATE_ATOM) : null,
            'canceledAt' => $this->canceledAt ? $this->canceledAt->format(DATE_ATOM) : null,
            'completedAt' => $this->completedAt ? $this->completedAt->format(DATE_ATOM) : null,
            'locale' => $this->locale,
            'mode' => $this->mode,
            'billingAddress' => $this->billingAddress->toArray(),
            'shopperCountryMustMatchBillingCountry' => $this->shopperCountryMustMatchBillingCountry,
            'consumerDateOfBirth' => $this->consumerDateOfBirth ? $this->consumerDateOfBirth->format(self::MOLLIE_DATE_FORMAT) : null,
            'orderNumber' => $this->orderNumber,
            'shippingAddress' => $this->shippingAddress ? $this->shippingAddress->toArray() : array(),
            'redirectUrl' => $this->redirectUrl,
            'webhookUrl' => $this->webhookUrl,
            'payment' => $this->payment ? $this->payment->toArray() : null,
            'lines' => $lines,
            '_embedded' => $embedded,
            '_links' => $links,
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
     * @return string[]
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string[] $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Amount $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return Amount
     */
    public function getAmountCaptured()
    {
        return $this->amountCaptured;
    }

    /**
     * @param Amount $amountCaptured
     */
    public function setAmountCaptured($amountCaptured)
    {
        $this->amountCaptured = $amountCaptured;
    }

    /**
     * @return Amount
     */
    public function getAmountRefunded()
    {
        return $this->amountRefunded;
    }

    /**
     * @param Amount $amountRefunded
     */
    public function setAmountRefunded($amountRefunded)
    {
        $this->amountRefunded = $amountRefunded;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isCancelable()
    {
        return $this->isCancelable;
    }

    /**
     * @param bool $isCancelable
     */
    public function setIsCancelable($isCancelable)
    {
        $this->isCancelable = $isCancelable;
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
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $expiresAt
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Calculates expire date
     *
     * @param int $daysToExpire
     */
    public function calculateExpiresAt($daysToExpire)
    {
        $this->expiresAt = new \DateTime();
        $this->expiresAt->add(new \DateInterval("P{$daysToExpire}D"));
    }

    /**
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime $expiredAt
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;
    }

    /**
     * @return \DateTime
     */
    public function getPaidAt()
    {
        return $this->paidAt;
    }

    /**
     * @param \DateTime $paidAt
     */
    public function setPaidAt($paidAt)
    {
        $this->paidAt = $paidAt;
    }

    /**
     * @return \DateTime
     */
    public function getAuthorizedAt()
    {
        return $this->authorizedAt;
    }

    /**
     * @param \DateTime $authorizedAt
     */
    public function setAuthorizedAt($authorizedAt)
    {
        $this->authorizedAt = $authorizedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCanceledAt()
    {
        return $this->canceledAt;
    }

    /**
     * @param \DateTime $canceledAt
     */
    public function setCanceledAt($canceledAt)
    {
        $this->canceledAt = $canceledAt;
    }

    /**
     * @return \DateTime
     */
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * @param \DateTime $completedAt
     */
    public function setCompletedAt($completedAt)
    {
        $this->completedAt = $completedAt;
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
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = SupportedLocale::ensureValidLocaleFormat($locale);
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return bool
     */
    public function isShopperCountryMustMatchBillingCountry()
    {
        return $this->shopperCountryMustMatchBillingCountry;
    }

    /**
     * @param bool $shopperCountryMustMatchBillingCountry
     */
    public function setShopperCountryMustMatchBillingCountry($shopperCountryMustMatchBillingCountry)
    {
        $this->shopperCountryMustMatchBillingCountry = $shopperCountryMustMatchBillingCountry;
    }

    /**
     * @return \DateTime
     */
    public function getConsumerDateOfBirth()
    {
        return $this->consumerDateOfBirth;
    }

    /**
     * @param \DateTime $consumerDateOfBirth
     */
    public function setConsumerDateOfBirth($consumerDateOfBirth)
    {
        $this->consumerDateOfBirth = $consumerDateOfBirth;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return Address|null
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param Address $shippingAddress
     */
    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     */
    public function setRedirectUrl($redirectUrl)
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getWebhookUrl()
    {
        return $this->webhookUrl;
    }

    /**
     * @param string $webhookUrl
     */
    public function setWebhookUrl($webhookUrl)
    {
        $this->webhookUrl = $webhookUrl;
    }

    /**
     * @return OrderLine[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @param OrderLine[] $lines
     */
    public function setLines($lines)
    {
        $this->lines = $lines;
    }

    /**
     * @return array
     */
    public function getEmbedded()
    {
        return $this->embedded;
    }

    /**
     * @param array $embedded
     */
    public function setEmbedded($embedded)
    {
        $this->embedded = $embedded;
    }

    /**
     * @return Link[]
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param string $type
     *
     * @return Link|null
     */
    public function getLink($type)
    {
        return array_key_exists($type, $this->links) ? $this->links[$type] : null;
    }

    /**
     * @param Link[] $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param Payment $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return array
     */
    public function getLinesMap()
    {
        $map = array();
        foreach ($this->getLines() as $line) {
            $map[$line->getId()] = $line;
        }

        return $map;
    }
}
