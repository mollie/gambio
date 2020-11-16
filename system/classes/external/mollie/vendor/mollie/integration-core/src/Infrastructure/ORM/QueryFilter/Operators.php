<?php

namespace Mollie\Infrastructure\ORM\QueryFilter;

/**
 * Class Operators.
 *
 * @package Mollie\Infrastructure\ORM\QueryFilter
 */
final class Operators
{
    const EQUALS = '=';
    const NOT_EQUALS = '!=';
    const GREATER_THAN = '>';
    const GREATER_OR_EQUAL_THAN = '>=';
    const LESS_THAN = '<';
    const LESS_OR_EQUAL_THAN = '<=';
    const LIKE = 'LIKE';
    const IN = 'IN';
    const NOT_IN = 'NOT IN';
    const NULL = 'IS NULL';
    const NOT_NULL = 'IS NOT NULL';
    public static $AVAILABLE_OPERATORS = array(
        self::EQUALS,
        self::NOT_EQUALS,
        self::GREATER_THAN,
        self::GREATER_OR_EQUAL_THAN,
        self::LESS_THAN,
        self::LESS_OR_EQUAL_THAN,
        self::LIKE,
        self::IN,
        self::NOT_IN,
        self::NULL,
        self::NOT_NULL,
    );
    public static $TYPE_OPERATORS = array(
        'integer' => array(
            self::EQUALS,
            self::NOT_EQUALS,
            self::GREATER_THAN,
            self::GREATER_OR_EQUAL_THAN,
            self::LESS_THAN,
            self::LESS_OR_EQUAL_THAN,
        ),
        'double' => array(
            self::EQUALS,
            self::NOT_EQUALS,
            self::GREATER_THAN,
            self::GREATER_OR_EQUAL_THAN,
            self::LESS_THAN,
            self::LESS_OR_EQUAL_THAN,
        ),
        'dateTime' => array(
            self::EQUALS,
            self::NOT_EQUALS,
            self::GREATER_THAN,
            self::GREATER_OR_EQUAL_THAN,
            self::LESS_THAN,
            self::LESS_OR_EQUAL_THAN,
        ),
        'string' => array(
            self::EQUALS,
            self::NOT_EQUALS,
            self::GREATER_THAN,
            self::GREATER_OR_EQUAL_THAN,
            self::LESS_THAN,
            self::LESS_OR_EQUAL_THAN,
            self::LIKE,
        ),
        'array' => array(
            self::IN,
            self::NOT_IN,
        ),
        'boolean' => array(
            self::EQUALS,
            self::NOT_EQUALS,
        ),
        'NULL' => array(
            self::NULL,
            self::NOT_NULL,
        ),
    );
}
