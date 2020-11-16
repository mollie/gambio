<?php

namespace Mollie\Gambio\Entity\Repository;

use Mollie\BusinessLogic\ORM\Interfaces\RepositoryInterface;
use Mollie\Infrastructure\ORM\Entity;
use Mollie\Infrastructure\ORM\Exceptions\QueryFilterInvalidParamException;
use Mollie\Infrastructure\ORM\QueryFilter\Operators;
use Mollie\Infrastructure\ORM\QueryFilter\QueryCondition;
use Mollie\Infrastructure\ORM\QueryFilter\QueryFilter;
use Mollie\Infrastructure\ORM\Utility\IndexHelper;

/**
 * Class BaseRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class BaseRepository implements RepositoryInterface
{
    const TABLE_NAME = 'mollie_entity';

    /**
     * @var \CI_DB_query_builder
     */
    protected $queryBuilder;
    /**
     * @var string
     */
    protected $entityClass;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->queryBuilder = \StaticGXCoreLoader::getDatabaseQueryBuilder();
    }

    /**
     * @inheritDoc
     */
    public function saveOrUpdate(Entity $entity)
    {
        if ($entity->getId()) {
            return $this->update($entity);
        }

        return $this->save($entity);
    }

    /**
     * @inheritDoc
     */
    public static function getClassName()
    {
        return __CLASS__;
    }

    /**
     * @inheritDoc
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * @inheritDoc
     */
    public function select(QueryFilter $filter = null)
    {
        $entities = [];
        $results  = $this->_buildWhere($filter)->select()->get(static::TABLE_NAME)->result('array');
        foreach ($results as $result) {
            $entities[] = $this->_toOrmEntity($result);
        }

        return $entities;
    }

    /**
     * @inheritDoc
     */
    public function selectOne(QueryFilter $filter = null)
    {
        $result = $this->_buildWhere($filter)->select()->get(static::TABLE_NAME, 1)->result('array');
        if (array_key_exists(0, $result)) {
            return $this->_toOrmEntity($result[0]);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function save(Entity $entity)
    {
        $data         = $this->_prepareForSave($entity);
        $data['type'] = $entity->getConfig()->getType();
        $success      = $this->queryBuilder->insert(static::TABLE_NAME, $data, true);
        if ($success) {
            $entity->setId($this->queryBuilder->insert_id());
            $this->update($entity);
        }
    }

    /**
     * @inheritDoc
     */
    public function update(Entity $entity)
    {
        $data  = $this->_prepareForSave($entity);
        $where = ['id' => $entity->getId()];
        $this->queryBuilder->update(static::TABLE_NAME, $data, $where);
    }

    /**
     * @inheritDoc
     */
    public function delete(Entity $entity)
    {
        $id = (int)$entity->getId();
        $this->queryBuilder->delete(static::TABLE_NAME, "id = $id");
    }

    /**
     * @inheritDoc
     */
    public function count(QueryFilter $filter = null)
    {
        return $this->_buildWhere($filter)->count_all_results(static::TABLE_NAME);
    }

    /**
     * @inheritDoc
     */
    public function deleteBy(QueryFilter $filter = null)
    {
        $this->_buildWhere($filter)->delete();
    }

    /**
     * @param QueryFilter|null $filter
     *
     * @return \CI_DB_query_builder
     * @throws QueryFilterInvalidParamException
     */
    protected function _buildWhere($filter)
    {
        /** @var Entity $type */
        $type = new $this->entityClass();
        $queryBuilder = $this->queryBuilder->where('type', $type->getConfig()->getType());
        if (!$filter) {
            return $queryBuilder;
        }

        foreach ($filter->getConditions() as $condition) {
            if ($condition->getColumn() === 'id') {
                $queryBuilder->where('id', $condition->getValue());
                continue;
            }

            if (!array_key_exists($condition->getColumn(), $this->_getIndexMap())) {
                throw new QueryFilterInvalidParamException("Field {$condition->getColumn()} is not indexed!");
            }

            $queryBuilder = $this->_addCondition($queryBuilder, $condition);
        }


        if ($filter->getLimit()) {
            $queryBuilder->limit($filter->getLimit());
        }

        if ($filter->getOffset()) {
            $queryBuilder->offset($filter->getOffset());
        }

        $this->_addOrderBy($queryBuilder, $filter);

        return $queryBuilder;
    }

    /**
     * @return array
     */
    protected function _getIndexMap()
    {
        $entityInstance = new $this->entityClass();

        return IndexHelper::mapFieldsToIndexes($entityInstance);
    }

    /**
     * Adds a single AND condition to SELECT query.
     *
     * @param \CI_DB_query_builder $queryBuilder Eloquent query builder.
     * @param QueryCondition       $condition    Mollie query condition.
     *
     * @return \CI_DB_query_builder Updated eloquent query builder.
     */
    protected function _addCondition(\CI_DB_query_builder $queryBuilder, QueryCondition $condition)
    {
        $isChainOrOperator = $condition->getChainOperator() === 'OR';
        $columnName        = $this->_resolveColumn($condition->getColumn());
        $conditionValue    = IndexHelper::castFieldValue($condition->getValue(), $condition->getValueType());
        switch ($condition->getOperator()) {
            case Operators::NULL:
                return $isChainOrOperator ? $queryBuilder->or_where($columnName)
                    : $queryBuilder->where($columnName);
            case Operators::NOT_NULL:
                return $isChainOrOperator ? $queryBuilder->or_where($columnName . ' IS NOT NULL')
                    : $queryBuilder->where($columnName . 'IS NOT NULL');
            case Operators::IN:
                return $isChainOrOperator ? $queryBuilder->or_where_in($columnName, $conditionValue)
                    : $queryBuilder->where_in($columnName, $conditionValue);
            case Operators::NOT_IN:
                return $isChainOrOperator ? $queryBuilder->or_where_not_in($columnName, $conditionValue)
                    : $queryBuilder->where_not_in($columnName, $conditionValue);
            default:
                return $isChainOrOperator ?
                    $queryBuilder->or_where($columnName . ' ' . $condition->getOperator(), $conditionValue)
                    : $queryBuilder->where($columnName . ' ' . $condition->getOperator(), $conditionValue);
        }
    }

    /**
     * Returns index mapped to given property.
     *
     * @param string $property Property name.
     *
     * @return string|null Index column in Mollie entity table, or null if it doesn't exist.
     */
    protected function _resolveColumn($property)
    {
        $indexMap = $this->_getIndexMap();
        if (array_key_exists($property, $indexMap)) {
            return 'index_' . $indexMap[$property];
        }

        return null;
    }

    /**
     * Transforms record to Mollie entity.
     *
     * @param array $record Database record.
     *
     * @return Entity Mollie entity.
     */
    protected function _toOrmEntity(array $record)
    {
        $jsonEntity = json_decode($record['data'], true);
        if (array_key_exists('class_name', $jsonEntity)) {
            $entity = new $jsonEntity['class_name'];
        } else {
            $entity = new $this->entityClass();
        }

        /** @var Entity $entity */
        $entity->inflate($jsonEntity);

        return $entity;
    }

    /**
     * @param Entity $entity
     *
     * @return array
     */
    protected function _prepareForSave(Entity $entity)
    {
        $preparedEntity         = [];
        $preparedEntity['data'] = json_encode($entity->toArray());
        $indexes                = IndexHelper::transformFieldsToIndexes($entity);

        foreach ($indexes as $index => $value) {
            $indexField                  = 'index_' . $index;
            $preparedEntity[$indexField] = $value;
        }

        return $preparedEntity;
    }

    /**
     * @param \CI_DB_query_builder $builder
     * @param QueryFilter $filter
     *
     * @throws QueryFilterInvalidParamException
     */
    private function _addOrderBy(\CI_DB_query_builder $builder, QueryFilter $filter)
    {
        $orderByColumn = $filter->getOrderByColumn();
        if ($orderByColumn !== null) {
            $indexedColumn = $orderByColumn === 'id' ? 'id' : $this->_resolveColumn($orderByColumn);
            if ($indexedColumn === null) {
                throw new QueryFilterInvalidParamException("Unknown or not indexed OrderBy column $orderByColumn");
            }

            $builder->order_by($indexedColumn, $filter->getOrderDirection());
        }
    }
}
