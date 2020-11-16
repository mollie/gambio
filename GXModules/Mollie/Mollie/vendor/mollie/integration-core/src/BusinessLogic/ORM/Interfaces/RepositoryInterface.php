<?php

namespace Mollie\BusinessLogic\ORM\Interfaces;

use Mollie\Infrastructure\ORM\Entity;
use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ORM\Interfaces\RepositoryInterface as InfrastructureRepositoryInterface;

/**
 * Interface RepositoryInterface.
 *
 * @package Mollie\BusinessLogic\ORM\Interfaces
 */
interface RepositoryInterface extends InfrastructureRepositoryInterface
{
    /**
     * Executes delete where query.
     *
     * @param QueryFilter $filter Filter for query.
     */
    public function deleteBy(QueryFilter $filter = null);

    /**
     * Executes insert or update query based on existence of id on provided entity instance.
     *
     * @param Entity $entity Entity to be saved or updated.
     *
     * @return int Identifier of saved or updated entity.
     */
    public function saveOrUpdate(Entity $entity);
}
