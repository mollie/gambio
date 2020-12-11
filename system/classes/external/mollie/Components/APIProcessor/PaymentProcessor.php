<?php

namespace Mollie\Gambio\APIProcessor;

use Mollie\BusinessLogic\Payments\PaymentService;
use Mollie\Gambio\Mappers\OrderMapper;
use Mollie\Gambio\Services\Business\StatusUpdate;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class PaymentProcessor
 *
 * @package Mollie\Gambio\APIProcessor
 */
class PaymentProcessor implements Interfaces\Processor
{

    use StatusUpdate;

    /**
     * @var PaymentService
     */
    private $paymentService;
    /**
     * @var OrderMapper
     */
    private $mapper;

    /**
     * PaymentProcessor constructor.
     *
     * @param OrderMapper $mapper
     */
    public function __construct(OrderMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @inheritDoc
     * @return Result
     */
    public function create($orderId)
    {
        try {
            $createdPayment = $this->_getPaymentService()->createPayment(
                $orderId,
                $this->mapper->getPayment($orderId)
            );

            $this->updateStatus($orderId, 'mollie_created');

            $links = $createdPayment->getLinks();
            $redirectUrl = array_key_exists('checkout', $links) ?
                $createdPayment->getLink('checkout')->getHref() :
                $createdPayment->getLink('changePaymentState')->getHref();

            return new Result(true, $redirectUrl);

        } catch (\Exception $exception) {
            $result = new Result(false);
            $result->setErrorMessage("Couldn't create payment on Mollie: {$exception->getMessage()}");

            return $result;
        }
    }

    /**
     * @return PaymentService
     */
    private function _getPaymentService()
    {
        if ($this->paymentService === null) {
            $this->paymentService = ServiceRegister::getService(PaymentService::CLASS_NAME);
        }

        return $this->paymentService;
    }

}