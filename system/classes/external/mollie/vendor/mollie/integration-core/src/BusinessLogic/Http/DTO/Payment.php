<?php

namespace Mollie\BusinessLogic\Http\DTO;

use Mollie\BusinessLogic\Http\DTO\Refunds\Refund;

/**
 * Class Payment
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class Payment extends BaseDto
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
    protected $profileId;
    /**
     * @var string
     */
    protected $orderId;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var Amount
     */
    protected $amount;
    /**
     * @var Amount
     */
    protected $amountRefunded;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var string
     */
    protected $redirectUrl;
    /**
     * @var string
     */
    protected $webhookUrl;
    /**
     * @var string
     */
    protected $locale;
    /**
     * @var string[]
     */
    protected $method;
    /**
     * @var Address
     */
    protected $shippingAddress;
    /**
     * @var array
     */
    protected $metadata = array();
    /**
     * @var Link[]
     */
    protected $links = array();
    /**
     * @var array
     */
    protected $embedded = array(
        'refunds' => array(),
    );

    /**
     * @var string
     */
    protected $cardToken;
    /**
     * @var string
     */
    protected $issuer;

    /**
     * @inheritDoc
     */
    public static function fromArray(array $raw)
    {
        $result = new static();

        $result->resource = static::getValue($raw, 'resource');
        $result->id = static::getValue($raw, 'id');
        $result->profileId = static::getValue($raw, 'profileId');
        $result->orderId = static::getValue($raw, 'orderId');
        $result->description = static::getValue($raw, 'description');
        $result->amount = Amount::fromArray(static::getValue($raw, 'amount', array()));
        $result->amountRefunded = Amount::fromArray(static::getValue($raw, 'amountRefunded', array()));
        $result->status = static::getValue($raw, 'status');
        $result->redirectUrl = static::getValue($raw, 'redirectUrl');
        $result->webhookUrl = static::getValue($raw, 'webhookUrl');
        $result->cardToken = static::getValue($raw, 'cardToken');
        $result->issuer = static::getValue($raw, 'issuer');
        $result->setLocale(static::getValue($raw, 'locale'));
        $method = static::getValue($raw, 'method', array());
        $method = is_array($method) ? $method : array($method);
        $result->method = $method;
        $result->metadata = static::getValue($raw, 'metadata', array());

        $shippingAddress = static::getValue($raw, 'shippingAddress', array());
        if (!empty($shippingAddress)) {
            $result->shippingAddress = Address::fromArray($shippingAddress);
        }

        foreach (static::getValue($raw, '_links', array()) as $linkKey => $linkData) {
            $result->links[$linkKey] = Link::fromArray($linkData);
        }

        if (array_key_exists('_embedded', $raw)) {
            $result->embedded['refunds'] = Refund::fromArrayBatch(static::getValue($raw['_embedded'], 'refunds', array()));
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $embedded = array(
            'refunds' => array(),
        );

        /** @var Refund $refund */
        foreach ($this->embedded['refunds'] as $refund) {
            $embedded['refunds'][] = $refund->toArray();
        }

        $links = array();
        foreach ($this->links as $linkKey => $link) {
            $links[$linkKey] = $link->toArray();
        }

        $result = array(
            'resource' => $this->resource,
            'id' => $this->id,
            'profileId' => $this->profileId,
            'orderId' => $this->orderId,
            'description' => $this->description,
            'amount' => $this->amount->toArray(),
            'amountRefunded' => $this->amountRefunded->toArray(),
            'status' => $this->status,
            'redirectUrl' => $this->redirectUrl,
            'webhookUrl' => $this->webhookUrl,
            'locale' => $this->locale,
            'method' => $this->method,
            'metadata' => $this->metadata,
            'cardToken' => $this->cardToken,
            'issuer' => $this->issuer,
            '_embedded' => $embedded,
            '_links' => $links,
        );

        if ($this->shippingAddress) {
            $result['shippingAddress'] = $this->shippingAddress->toArray();
        }

        return $result;
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
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
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
     * @return string
     */
    public function getCardToken()
    {
        return $this->cardToken;
    }

    /**
     * @param string $cardToken
     */
    public function setCardToken($cardToken)
    {
        $this->cardToken = $cardToken;
    }

    /**
     * @return string
     */
    public function getIssuer()
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer($issuer)
    {
        $this->issuer = $issuer;
    }
}
