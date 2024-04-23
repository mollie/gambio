<?php

namespace Mollie\BusinessLogic\Http\DTO\Refunds;

use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\BaseDto;
use Mollie\BusinessLogic\Http\DTO\Link;
use Mollie\BusinessLogic\Http\DTO\Orders\OrderLine;

/**
 * Class Refund
 *
 * @package Mollie\BusinessLogic\Http\DTO\Refunds
 */
class Refund extends BaseDto
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
     * @var Amount
     */
    protected $amount;
    /**
     * @var string
     */
    protected $settlementId;
    /**
     * @var Amount
     */
    protected $settlementAmount;
    /**
     * @var string
     */
    protected $status;
    /**
     * @var OrderLine[]
     */
    protected $lines = array();
    /**
     * @var \DateTime
     */
    protected $createdAt;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var mixed
     */
    protected $metadata;
    /**
     * @var string
     */
    protected $paymentId;
    /**
     * @var string
     */
    protected $orderId;
    /**
     * @var Link[]
     */
    protected $links = array();

    /**
     * @param array $raw
     *
     * @return Refund
     */
    public static function fromArray(array $raw)
    {
        $refund = new static();
        $refund->resource = static::getValue($raw, 'resource');
        $refund->id = static::getValue($raw, 'id');
        $refund->amount = Amount::fromArray(static::getValue($raw, 'amount', array()));
        $refund->settlementId = static::getValue($raw, 'settlementId');
        $refund->settlementAmount = Amount::fromArray(static::getValue($raw, 'settlementAmount', array()));
        $refund->status = static::getValue($raw, 'status');
        $refund->lines = OrderLine::fromArrayBatch(static::getValue($raw, 'lines', array()));
        $refund->createdAt = \DateTime::createFromFormat(DATE_ATOM, static::getValue($raw, 'createdAt'));
        $refund->description = static::getValue($raw, 'description');
        $refund->metadata = (array)static::getValue($raw, 'metadata', null);
        $refund->paymentId = static::getValue($raw, 'paymentId');
        $refund->orderId = static::getValue($raw, 'orderId');

        foreach ((array)static::getValue($raw, '_links', array()) as $linkKey => $linkData) {
            $refund->links[$linkKey] = Link::fromArray((array)$linkData);
        }

        return $refund;
    }

    /**
     * @return array|void
     */
    public function toArray()
    {
        $links = array();
        foreach ($this->links as $linkKey => $link) {
            $links[$linkKey] = $link->toArray();
        }

        $lines = array();
        foreach ($this->lines as $line) {
            $lines[] = $line->toArray();
        }

        return array(
            'resource' => $this->resource,
            'id' => $this->id,
            'amount' => $this->amount->toArray(),
            'settlementId' => $this->settlementId,
            'settlementAmount' => $this->settlementAmount->toArray(),
            'status' => $this->status,
            'lines' => $lines,
            'createdAt' => $this->createdAt ? $this->createdAt->format(DATE_ATOM) : null,
            'description' => $this->description,
            'metadata' => $this->metadata,
            'paymentId' => $this->paymentId,
            'orderId' => $this->orderId,
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
     * @return string
     */
    public function getSettlementId()
    {
        return $this->settlementId;
    }

    /**
     * @param string $settlementId
     */
    public function setSettlementId($settlementId)
    {
        $this->settlementId = $settlementId;
    }

    /**
     * @return Amount
     */
    public function getSettlementAmount()
    {
        return $this->settlementAmount;
    }

    /**
     * @param Amount $settlementAmount
     */
    public function setSettlementAmount($settlementAmount)
    {
        $this->settlementAmount = $settlementAmount;
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
     * @return mixed
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param mixed $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param string $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
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
    public function getRefundLinesMap()
    {
        $map = array();
        foreach ($this->getLines() as $line) {
            $map[$line->getId()] = $line;
        }

        return $map;
    }
}
