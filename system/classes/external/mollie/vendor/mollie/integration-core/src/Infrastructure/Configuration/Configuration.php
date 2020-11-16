<?php
/** @noinspection PhpDocMissingThrowsInspection */

/** @noinspection PhpUnusedParameterInspection */

namespace Mollie\Infrastructure\Configuration;

use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\Singleton;

/**
 * Class Configuration.
 *
 * @package Mollie\Infrastructure\Configuration
 */
abstract class Configuration extends Singleton
{
    /**
     * Fully qualified name of this interface.
     */
    const CLASS_NAME = __CLASS__;
    /**
     * Minimal log level
     */
    const MIN_LOG_LEVEL = 3;
    /**
     * System user context.
     *
     * @var string
     */
    protected $context = '';
    /**
     * Configuration repository.
     *
     * @var \Mollie\Infrastructure\ORM\Interfaces\RepositoryInterface
     */
    protected $repository;

    /**
     * Retrieves integration name.
     *
     * @return string Integration name.
     */
    abstract public function getIntegrationName();

    /**
     * Returns current system identifier.
     *
     * @return string Current system identifier.
     */
    abstract public function getCurrentSystemId();

    /**
     * Returns current system name.
     *
     * @return string Current system name.
     */
    abstract public function getCurrentSystemName();

    /**
     * Sets task execution context.
     *
     * When integration supports multiple accounts (middleware integration) proper context must be set based on
     * middleware account that is using core library functionality. This context should then be used by business
     * services to fetch account specific data.Core will set context provided upon task enqueueing before task
     * execution.
     *
     * @param string $context Context to set.
     */
    public function setContext($context)
    {
        $this->context = (string)$context;
    }

    /**
     * Gets task execution context.
     *
     * @return string
     *  Context in which task is being executed. If no context is provided empty string is returned (global context).
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Invokes action in a given context. After action is executed, original context is restored.
     *
     * @param string $context
     * @param callable $action
     *
     * @return mixed Result of action
     */
    public function doWithContext($context, callable $action)
    {
        $originalContext = $this->getContext();

        $this->setContext($context);
        $result = call_user_func($action);

        $this->setContext($originalContext);

        return $result;
    }

    /**
     * Saves min log level in integration database.
     *
     * @param int $minLogLevel Min log level.
     */
    public function saveMinLogLevel($minLogLevel)
    {
        $this->saveConfigValue('minLogLevel', $minLogLevel);
    }

    /**
     * Retrieves min log level from integration database.
     *
     * @return int Min log level.
     */
    public function getMinLogLevel()
    {
        return $this->getConfigValue('minLogLevel', static::MIN_LOG_LEVEL);
    }

    /**
     * Set default logger status (enabled/disabled).
     *
     * @param bool $status TRUE if default logger is enabled; otherwise, false.
     */
    public function setDefaultLoggerEnabled($status)
    {
        $this->saveConfigValue('defaultLoggerEnabled', (bool)$status);
    }

    /**
     * Return whether default logger is enabled or not.
     *
     * @return bool TRUE if default logger is enabled; otherwise, false.
     */
    public function isDefaultLoggerEnabled()
    {
        return $this->getConfigValue('defaultLoggerEnabled', false);
    }

    /**
     * Sets debug mode status (enabled/disabled).
     *
     * @param bool $status TRUE if debug mode is enabled; otherwise, false.
     */
    public function setDebugModeEnabled($status)
    {
        $this->saveConfigValue('debugModeEnabled', (bool)$status);
    }

    /**
     * Returns debug mode status.
     *
     * @return bool TRUE if debug mode is enabled; otherwise, false.
     */
    public function isDebugModeEnabled()
    {
        return $this->getConfigValue('debugModeEnabled', false);
    }

    /**
     * Gets configuration value for given name.
     *
     * @param string $name Name of the config parameter.
     * @param mixed $default Default value if config entity does not exist.
     *
     * @return mixed Value of config entity if found; otherwise, default value provided in $default parameter.
     */
    protected function getConfigValue($name, $default = null)
    {
        $entity = $this->getConfigEntity($name);

        return $entity ? $entity->getValue() : $default;
    }

    /**
     * Returns configuration entity with provided name.
     *
     * @param string $name Configuration property name.
     *
     * @return \Mollie\Infrastructure\Configuration\ConfigEntity Configuration entity, if found; otherwise, null;
     */
    protected function getConfigEntity($name)
    {
        $filter = new QueryFilter();
        /** @noinspection PhpUnhandledExceptionInspection */
        $filter->where('name', '=', $name);
        if ($this->isSystemSpecific($name)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $filter->where('systemId', '=', $this->getCurrentSystemId());
        }

        if ($this->isContextSpecific($name)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $filter->where('context', '=', $this->getContext());
        }

        /** @var ConfigEntity $config */
        $config = $this->getRepository()->selectOne($filter);

        return $config;
    }

    /**
     * Saves configuration value or updates it if it already exists.
     *
     * @param string $name Configuration property name.
     * @param mixed $value Configuration property value.
     *
     * @return \Mollie\Infrastructure\Configuration\ConfigEntity
     */
    protected function saveConfigValue($name, $value)
    {
        /** @var ConfigEntity $config */
        $config = $this->getConfigEntity($name) ?: new ConfigEntity();
        if ($this->isSystemSpecific($name)) {
            $config->setSystemId($this->getCurrentSystemId());
        }

        if ($this->isContextSpecific($name)) {
            $config->setContext($this->getContext());
        }

        $config->setValue($value);
        if ($config->getId() === null) {
            $config->setName($name);
            $this->getRepository()->save($config);
        } else {
            $this->getRepository()->update($config);
        }

        return $config;
    }

    /**
     * Determines whether the configuration entry is system specific.
     *
     * @param string $name Configuration entry name.
     *
     * @return bool
     */
    protected function isSystemSpecific($name)
    {
        return true;
    }

    /**
     * Determines whether the configuration entry is context specific.
     *
     * @param string $name Configuration entry name.
     *
     * @return bool
     */
    protected function isContextSpecific($name)
    {
        return !in_array($name, array('minLogLevel', 'defaultLoggerEnabled', 'debugModeEnabled'));
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * Returns repository instance.
     *
     * @return \Mollie\Infrastructure\ORM\Interfaces\RepositoryInterface Configuration repository.
     */
    protected function getRepository()
    {
        if ($this->repository === null) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $this->repository = RepositoryRegistry::getRepository(ConfigEntity::getClassName());
        }

        return $this->repository;
    }
}
