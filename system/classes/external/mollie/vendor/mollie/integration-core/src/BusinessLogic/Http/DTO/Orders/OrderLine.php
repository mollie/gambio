<?php

namespace Mollie\BusinessLogic\Http\DTO\Orders;

use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\BaseDto;
use Mollie\BusinessLogic\Http\DTO\Link;

/**
 * Class OrderLine
 *
 * @package Mollie\BusinessLogic\Http\DTO\Orders
 */
class OrderLine extends BaseDto
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $orderId;
    /**
     * @var string
     */
    protected $resource;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var bool
     */
    protected $isCancelable;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $quantity;
    /**
     * @var int
     */
    protected $quantityShipped;
    /**
     * @var Amount
     */
    protected $amountShipped;
    /**
     * @var int
     */
    protected $quantityRefunded;
    /**
     * @var Amount
     */
    protected $amountRefunded;
    /**
     * @var int
     */
    protected $quantityCanceled;
    /**
     * @var Amount
     */
    protected $amountCanceled;
    /**
     * @var Amount
     */
    protected $unitPrice;
    /**
     * @var Amount
     */
    protected $totalAmount;
    /**
     * @var string
     */
    protected $vatRate;
    /**
     * @var Amount
     */
    protected $vatAmount;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var Amount
     */
    protected $discountAmount;
    /**
     * @var string
     */
    protected $sku;
    /**
     * @var Link[]
     */
    protected $links = array();
    /**
     * @var array
     */
    protected $metadata = array();
    /**
     * @var int
     */
    protected $shippableQuantity;
    /**
     * @var int
     */
    protected $refundableQuantity;
    /**
     * @var int
     */
    protected $cancelableQuantity;
    /**
     * @var string
     */
    protected $category;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @param array $raw
     *
     * @return OrderLine
     */
    public static function fromArray(array $raw)
    {
        $orderLine = new static();
        $orderLine->name = static::getValue($raw, 'name');
        $orderLine->quantity = (int)static::getValue($raw, 'quantity', 0);
        $orderLine->vatRate = static::getValue($raw, 'vatRate');
        $orderLine->unitPrice = Amount::fromArray(static::getValue($raw, 'unitPrice', array()));
        $orderLine->totalAmount = Amount::fromArray(static::getValue($raw, 'totalAmount', array()));
        $orderLine->vatAmount = Amount::fromArray(static::getValue($raw, 'vatAmount', array()));
        $discountAmount = static::getValue($raw, 'discountAmount', array());
        $orderLine->discountAmount = !empty($discountAmount) ? Amount::fromArray($discountAmount) : null;
        $orderLine->type = static::getValue($raw, 'type', null);
        $orderLine->sku = static::getValue($raw, 'sku', null);

        $orderLine->metadata = static::getValue($raw, 'metadata', array());
        $orderLine->id = static::getValue($raw, 'id');
        $orderLine->orderId = static::getValue($raw, 'orderId');
        $orderLine->isCancelable = static::getValue($raw, 'isCancelable', false);
        $orderLine->resource = static::getValue($raw, 'resource');

        $orderLine->quantityShipped = (int)static::getValue($raw, 'quantityShipped', 0);
        $orderLine->amountShipped = Amount::fromArray(static::getValue($raw, 'amountShipped', array()));

        $orderLine->quantityRefunded = (int)static::getValue($raw, 'quantityRefunded', 0);
        $orderLine->amountRefunded = Amount::fromArray(static::getValue($raw, 'amountRefunded', array()));

        $orderLine->quantityCanceled = (int)static::getValue($raw, 'quantityCanceled', 0);
        $orderLine->amountCanceled = Amount::fromArray(static::getValue($raw, 'amountCanceled', array()));

        $orderLine->shippableQuantity = (int)static::getValue($raw, 'shippableQuantity', 0);
        $orderLine->refundableQuantity = (int)static::getValue($raw, 'refundableQuantity', 0);
        $orderLine->cancelableQuantity = (int)static::getValue($raw, 'cancelableQuantity', 0);
        $orderLine->status = static::getValue($raw, 'status');

        $orderLine->category = static::getValue($raw, 'category');

        $orderLine->createdAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'createdAt'));

        foreach (static::getValue($raw, '_links', array()) as $linkKey => $linkData) {
            $orderLine->links[$linkKey] = Link::fromArray($linkData);
        }

        return $orderLine;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $links = array();
        foreach ($this->links as $linkKey => $link) {
            $links[$linkKey] = $link->toArray();
        }

        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'orderId' => $this->orderId,
            'sku' => $this->sku,
            'name' => $this->name,
            'type'=> $this->type,
            'status'=> $this->status,
            'metadata' => $this->metadata,
            'isCancelable' => $this->isCancelable,
            'quantity' => $this->quantity,
            'quantityShipped' => $this->quantityShipped,
            'amountShipped' => $this->amountShipped ? $this->amountShipped->toArray() : array(),
            'quantityRefunded' => $this->quantityRefunded,
            'amountRefunded' => $this->amountRefunded ? $this->amountRefunded->toArray() : array(),
            'quantityCanceled' => $this->quantityCanceled,
            'amountCanceled' => $this->amountCanceled ? $this->amountCanceled->toArray() : array(),
            'shippableQuantity' => $this->shippableQuantity,
            'refundableQuantity' => $this->refundableQuantity,
            'cancelableQuantity' => $this->cancelableQuantity,
            'unitPrice' => $this->unitPrice  ? $this->unitPrice->toArray() : array(),
            'vatRate' => $this->vatRate,
            'vatAmount' => $this->vatAmount ? $this->vatAmount->toArray() : array(),
            'discountAmount' => $this->discountAmount ? $this->discountAmount->toArray() : array(),
            'totalAmount' => $this->totalAmount ? $this->totalAmount->toArray() : array(),
            'category' => $this->category,
            'createdAt' => $this->createdAt ? $this->createdAt->format(DATE_ATOM) : null,
            '_links' => $links,
        );
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
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantityShipped()
    {
        return $this->quantityShipped;
    }

    /**
     * @param int $quantityShipped
     */
    public function setQuantityShipped($quantityShipped)
    {
        $this->quantityShipped = $quantityShipped;
    }

    /**
     * @return Amount
     */
    public function getAmountShipped()
    {
        return $this->amountShipped;
    }

    /**
     * @param Amount $amountShipped
     */
    public function setAmountShipped($amountShipped)
    {
        $this->amountShipped = $amountShipped;
    }

    /**
     * @return int
     */
    public function getQuantityRefunded()
    {
        return $this->quantityRefunded;
    }

    /**
     * @param int $quantityRefunded
     */
    public function setQuantityRefunded($quantityRefunded)
    {
        $this->quantityRefunded = $quantityRefunded;
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
     * @return int
     */
    public function getQuantityCanceled()
    {
        return $this->quantityCanceled;
    }

    /**
     * @param int $quantityCanceled
     */
    public function setQuantityCanceled($quantityCanceled)
    {
        $this->quantityCanceled = $quantityCanceled;
    }

    /**
     * @return Amount
     */
    public function getAmountCanceled()
    {
        return $this->amountCanceled;
    }

    /**
     * @param Amount $amountCanceled
     */
    public function setAmountCanceled($amountCanceled)
    {
        $this->amountCanceled = $amountCanceled;
    }

    /**
     * @return Amount
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param Amount $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return Amount
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param Amount $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return string
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * @param string $vatRate
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
    }

    /**
     * @return Amount
     */
    public function getVatAmount()
    {
        return $this->vatAmount;
    }

    /**
     * @param Amount $vatAmount
     */
    public function setVatAmount($vatAmount)
    {
        $this->vatAmount = $vatAmount;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Amount|null
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param Amount $discountAmount
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
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
     * @return int
     */
    public function getShippableQuantity()
    {
        return $this->shippableQuantity;
    }

    /**
     * @param int $shippableQuantity
     */
    public function setShippableQuantity($shippableQuantity)
    {
        $this->shippableQuantity = $shippableQuantity;
    }

    /**
     * @return int
     */
    public function getRefundableQuantity()
    {
        return $this->refundableQuantity;
    }

    /**
     * @param int $refundableQuantity
     */
    public function setRefundableQuantity($refundableQuantity)
    {
        $this->refundableQuantity = $refundableQuantity;
    }

    /**
     * @return int
     */
    public function getCancelableQuantity()
    {
        return $this->cancelableQuantity;
    }

    /**
     * @param int $cancelableQuantity
     */
    public function setCancelableQuantity($cancelableQuantity)
    {
        $this->cancelableQuantity = $cancelableQuantity;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}