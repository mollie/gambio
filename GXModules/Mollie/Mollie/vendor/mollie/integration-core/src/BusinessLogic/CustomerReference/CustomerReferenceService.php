<?php

namespace Mollie\BusinessLogic\CustomerReference;

use Mollie\BusinessLogic\BaseService;
use Mollie\BusinessLogic\CustomerReference\Model\CustomerReference;
use Mollie\BusinessLogic\Http\DTO\Customer;
use Mollie\BusinessLogic\ORM\Interfaces\RepositoryInterface;
use Mollie\Infrastructure\ORM\QueryFilter\Operators;
use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ORM\RepositoryRegistry;

/**
 * Class CustomerReferenceService
 *
 * @package Mollie\BusinessLogic\CustomerReference
 */
class CustomerReferenceService extends BaseService
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
     * Stores customer in shop database
     *
     * @param Customer $customer
     * @param string $shopReference
     *
     * @return int
     */
    public function saveCustomerReference(Customer $customer, $shopReference)
    {
        $customerReference = new CustomerReference();
        $customerReference->setShopReference($shopReference);
        $customerReference->setMollieReference($customer->getId());
        $customerReference->setPayload($customer->toArray());

        return $this->getRepository(CustomerReference::CLASS_NAME)->save($customerReference);
    }

    /**
     * Return customer by its shop identifier
     *
     * @param string $shopReference
     *
     * @return CustomerReference|null
     */
    public function getByShopReference($shopReference)
    {
        /** @var CustomerReference|null $customerReference */
        $customerReference = $this->getRepository(CustomerReference::CLASS_NAME)->selectOne(
            $this->setFilterCondition(
                new QueryFilter(), 'shopReference', Operators::EQUALS, (string)$shopReference
            )
        );

        return $customerReference;
    }

    /**
     * Return customer by its Mollie identifier
     *
     * @param string $mollieReference
     *
     * @return CustomerReference|null
     */
    public function getByMollieReference($mollieReference)
    {
        /** @var CustomerReference|null $customerReference */
        $customerReference = $this->getRepository(CustomerReference::CLASS_NAME)->selectOne(
            $this->setFilterCondition(
                new QueryFilter(), 'mollieReference', Operators::EQUALS, (string)$mollieReference
            )
        );

        return $customerReference;
    }

    /**
     * Removes customer from customer reference table by its shop identifier
     *
     * @param string $shopReference
     */
    public function deleteByShopReference($shopReference)
    {
        $this->getRepository(CustomerReference::CLASS_NAME)->deleteBy(
            $this->setFilterCondition(
                new QueryFilter(), 'shopReference', Operators::EQUALS, (string)$shopReference
            )
        );
    }
}