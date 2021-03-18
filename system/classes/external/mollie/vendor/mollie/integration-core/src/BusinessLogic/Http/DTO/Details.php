<?php


namespace Mollie\BusinessLogic\Http\DTO;

/**
 * Class Details
 *
 * @package Mollie\BusinessLogic\Http\DTO
 */
class Details extends BaseDto
{

    /**
     * @var string
     */
    protected $issuer;
    /**
     * @var Amount
     */
    protected $reminderAmount;
    /**
     * @var string
     */
    protected $remainderMethod;
    /**
     * @var Voucher[]
     */
    protected $vouchers = array();

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        $vouchers = array();
        foreach ($this->vouchers as $voucher) {
            $vouchers[] = $voucher->toArray();
        }

        return array(
            'issuer' => $this->issuer,
            'vouchers' => $vouchers,
            'remainderAmount' => $this->reminderAmount ? $this->reminderAmount->toArray() : null,
            'remainderMethod' => $this->remainderMethod,
        );
    }

    /**
     * @param array $raw
     *
     * @return Details|static
     */
    public static function fromArray(array $raw)
    {
        $reminderDetails = new static();
        $reminderDetails->issuer = static::getValue($raw, 'issuer');
        $reminderDetails->reminderAmount = Amount::fromArray(static::getValue($raw, 'remainderAmount', array()));
        $reminderDetails->remainderMethod = static::getValue($raw, 'remainderMethod');
        if (!empty($raw['vouchers'])) {
            $reminderDetails->vouchers = Voucher::fromArrayBatch($raw['vouchers']);
        }

        return $reminderDetails;
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

    /**
     * @return Amount
     */
    public function getReminderAmount()
    {
        return $this->reminderAmount;
    }

    /**
     * @param Amount $reminderAmount
     */
    public function setReminderAmount($reminderAmount)
    {
        $this->reminderAmount = $reminderAmount;
    }

    /**
     * @return string
     */
    public function getRemainderMethod()
    {
        return $this->remainderMethod;
    }

    /**
     * @param string $remainderMethod
     */
    public function setRemainderMethod($remainderMethod)
    {
        $this->remainderMethod = $remainderMethod;
    }

    /**
     * @return Voucher[]
     */
    public function getVouchers()
    {
        return $this->vouchers;
    }

    /**
     * @param Voucher[] $vouchers
     */
    public function setVouchers($vouchers)
    {
        $this->vouchers = $vouchers;
    }

    /**
     * @return float
     */
    public function calculateVoucherAmount()
    {
        $total = 0;
        foreach ($this->vouchers as $voucher) {
            $value = $voucher->getAmount() ? $voucher->getAmount()->getAmountValue() : 0;
            $total += $value;
        }

        return $total;
    }
}
