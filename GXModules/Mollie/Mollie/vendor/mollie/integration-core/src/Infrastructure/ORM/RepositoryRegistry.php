<?php

namespace Mollie\Infrastructure\ORM;

use Mollie\Infrastructure\ORM\Exceptions\RepositoryClassException;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;
use Mollie\Infrastructure\ORM\Interfaces\RepositoryInterface;

/**
 * Class RepositoryRegistry.
 *
 * @package Mollie\Infrastructure\ORM
 */
class RepositoryRegistry
{
    /**
     * @var RepositoryInterface[]
     */
    protected static $instantiated = array();
    /**
     * @var array
     */
    protected static $repositories = array();

    /**
     * Returns an instance of repository that is responsible for handling the entity
     *
     * @param string $entityClass Class name of entity.
     *
     * @return RepositoryInterface
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    public static function getRepository($entityClass)
    {
        if (!array_key_exists($entityClass, self::$repositories)) {
            throw new RepositoryNotRegisteredException("Repository for entity $entityClass not found or registered.");
        }

        if (!array_key_exists($entityClass, self::$instantiated)) {
            $repositoryClass = self::$repositories[$entityClass];
            /** @var RepositoryInterface $repository */
            $repository = new $repositoryClass();
            $repository->setEntityClass($entityClass);
            self::$instantiated[$entityClass] = $repository;
        }

        return self::$instantiated[$entityClass];
    }

    /**
     * Registers repository for provided entity class
     *
     * @param string $entityClass Class name of entity.
     * @param string $repositoryClass Class name of repository.
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryClassException
     */
    public static function registerRepository($entityClass, $repositoryClass)
    {
        if (!is_subclass_of($repositoryClass, RepositoryInterface::CLASS_NAME)) {
            throw new RepositoryClassException("Class $repositoryClass is not implementation of RepositoryInterface.");
        }

        unset(self::$instantiated[$entityClass]);
        self::$repositories[$entityClass] = $repositoryClass;
    }
}
