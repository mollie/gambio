<?php

namespace Mollie\Infrastructure\ORM\QueryFilter;

use DateTime;
use Mollie\Infrastructure\ORM\Exceptions\QueryFilterInvalidParamException;

/**
 * Class QueryFilter.
 *
 * @package Mollie\Infrastructure\ORM
 */
class QueryFilter
{
    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';
    /**
     * List of filter conditions.
     *
     * @var QueryCondition[]
     */
    private $conditions = array();
    /**
     * Order by column name.
     *
     * @var string
     */
    private $orderByColumn;
    /**
     * Order direction.
     *
     * @var string
     */
    private $orderDirection = 'ASC';
    /**
     * Limit for select.
     *
     * @var int
     */
    private $limit;
    /**
     * Offset for select.
     *
     * @var int
     */
    private $offset;

    /**
     * Gets limit for select.
     *
     * @return int Limit for select.
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Sets limit for select.
     *
     * @param int $limit Limit for select.
     *
     * @return self This instance for chaining.
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Gets select offset.
     *
     * @return int Offset.
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Sets select offset.
     *
     * @param int $offset Offset.
     *
     * @return self This instance for chaining.
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Sets order by column and direction
     *
     * @param string $column Column name.
     * @param string $direction Order direction (@see self::ORDER_ASC or @see self::ORDER_DESC).
     *
     * @return self This instance for chaining.
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\QueryFilterInvalidParamException
     */
    public function orderBy($column, $direction = self::ORDER_ASC)
    {
        if (!is_string($column) || !in_array($direction, array(self::ORDER_ASC, self::ORDER_DESC), false)) {
            throw new QueryFilterInvalidParamException(
                'Column value must be string type and direction must be ASC or DESC'
            );
        }

        $this->orderByColumn = $column;
        $this->orderDirection = $direction;

        return $this;
    }

    /**
     * Gets name for order by column.
     *
     * @return string Order column name.
     */
    public function getOrderByColumn()
    {
        return $this->orderByColumn;
    }

    /**
     * Gets order direction.
     *
     * @return string Order direction (@see self::ORDER_ASC or @see self::ORDER_DESC)
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * Gets all conditions for this filter.
     *
     * @return QueryCondition[] Filter conditions.
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Sets where condition, if chained AND operator will be used
     *
     * @param string $column Column name.
     * @param string $operator Operator. Use constants from @see Operator class.
     * @param mixed $value Value of condition.
     *
     * @return self This instance for chaining.
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\QueryFilterInvalidParamException
     */
    public function where($column, $operator, $value = null)
    {
        $this->validateConditionParameters($column, $operator, $value);

        $this->conditions[] = new QueryCondition('AND', $column, $operator, $value);

        return $this;
    }

    /**
     * Sets where condition, if chained OR operator will be used.
     *
     * @param string $column Column name.
     * @param string $operator Operator. Use constants from @see Operator class.
     * @param mixed $value Value of condition.
     *
     * @return self This instance for chaining.
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\QueryFilterInvalidParamException
     */
    public function orWhere($column, $operator, $value = null)
    {
        $this->validateConditionParameters($column, $operator, $value);

        $this->conditions[] = new QueryCondition('OR', $column, $operator, $value);

        return $this;
    }

    /**
     * Validates condition parameters.
     *
     * @param string $column Column name.
     * @param string $operator Operator. Use constants from @see Operator class.
     * @param mixed $value Value of condition.
     *
     * @throws \Mollie\Infrastructure\ORM\Exceptions\QueryFilterInvalidParamException
     */
    private function validateConditionParameters($column, $operator, $value)
    {
        if (!is_string($column) || !is_string($operator)) {
            throw new QueryFilterInvalidParamException('Column and operator values must be string types');
        }

        $operator = strtoupper($operator);
        if (!in_array($operator, Operators::$AVAILABLE_OPERATORS, true)) {
            throw new QueryFilterInvalidParamException("Operator $operator is not supported");
        }

        $valueType = gettype($value);
        if ($valueType === 'object' && $value instanceof DateTime) {
            $valueType = 'dateTime';
        }

        if (!array_key_exists($valueType, Operators::$TYPE_OPERATORS)) {
            throw new QueryFilterInvalidParamException('Value type is not supported');
        }

        if (!in_array($operator, Operators::$TYPE_OPERATORS[$valueType], true)) {
            throw new QueryFilterInvalidParamException("Operator $operator is not supported for $valueType type");
        }
    }
}
