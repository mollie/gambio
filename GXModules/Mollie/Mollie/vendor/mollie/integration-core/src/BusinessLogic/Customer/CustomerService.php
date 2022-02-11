<?php

namespace Mollie\BusinessLogic\Customer;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\CustomerReference\CustomerReferenceService;
use Mollie\BusinessLogic\Http\DTO\Customer;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ServiceRegister;

/**
 * Class CustomerService
 *
 * @package Mollie\BusinessLogic\Customer
 */
class CustomerService extends BaseService
{
    /**
     * Fully qualified name of this class.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Singleton instance of this class.
     *
     * @var static
     */
    protected static $instance;

    /**
     * @param Customer $customer
     * @param $shopReference
     *
     * @return string|null ID of created customer, null if not created
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function createCustomer(Customer $customer, $shopReference)
    {
        $customerReference = $this->getCustomerReferenceService()->getByShopReference($shopReference);

        if ($customerReference) {
            return $customerReference->getMollieReference();
        }

        $mollieCustomer = $this->getProxy()->createCustomer($customer);
        $this->getCustomerReferenceService()->saveCustomerReference($mollieCustomer, $shopReference);
        return $mollieCustomer->getId() !== '' ? $mollieCustomer->getId() : null;
    }

    /**
     * Returns customer id from local db by shop reference
     *
     * @param $shopReference
     *
     * @return string|null
     */
    public function getSavedCustomerId($shopReference)
    {
        $customer = $this->getCustomerReferenceService()->getByShopReference($shopReference);

        return $customer ? $customer->getMollieReference() : null;
    }

    /**
     * Removes customer from local database and from mollie api
     *
     * @param string $shopReference
     *
     * @throws UnprocessableEntityRequestException
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     */
    public function removeCustomer($shopReference)
    {
        $customerReference = $this->getCustomerReferenceService()->getByShopReference($shopReference);

        if ($customerReference) {
            $this->getProxy()->deleteCustomer($customerReference->getMollieReference());
        }

        $this->getCustomerReferenceService()->deleteByShopReference($shopReference);
    }

    /**
     * @return CustomerReferenceService
     */
    protected function getCustomerReferenceService()
    {
        /** @var CustomerReferenceService $customerReferenceService */
        $customerReferenceService = ServiceRegister::getService(CustomerReferenceService::CLASS_NAME);

        return $customerReferenceService;
    }
}