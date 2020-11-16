<?php

namespace Mollie\BusinessLogic;

use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\ORM\Interfaces\RepositoryInterface;
use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;
use Mollie\Infrastructure\Singleton;

/**
 * Base class for all services. Initializes service as a singleton instance.
 *
 * @package Mollie\BusinessLogic
 */
abstract class BaseService extends Singleton
{
    /**
     * @var Proxy
     */
    private $proxy;

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * Returns an instance of repository for entity.
     *
     * @param string $entityClass Name of entity class.
     *
     * @return RepositoryInterface Instance of a repository.
     */
    protected function getRepository($entityClass)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        /** @var RepositoryInterface $repository */
        $repository = RepositoryRegistry::getRepository($entityClass);

        return $repository;
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * Sets filter condition. Wrapper method for suppressing warning.
     *
     * @param QueryFilter $filter Filter object.
     * @param string $column Column name.
     * @param string $operator Operator. Use constants from @see Operator class.
     * @param mixed $value Value of condition.
     *
     * @return QueryFilter Filter for chaining.
     */
    protected function setFilterCondition(QueryFilter $filter, $column, $operator, $value = null)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return $filter->where($column, $operator, $value);
    }

    /**
     * @return Proxy
     */
    protected function getProxy()
    {
        if ($this->proxy === null) {
            $this->proxy = ServiceRegister::getService(Proxy::CLASS_NAME);
        }

        return $this->proxy;
    }
}
