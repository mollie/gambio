<?php

namespace Mollie\Infrastructure\ORM\Utility;

use DateTime;
use Mollie\Infrastructure\ORM\Entity;

/**
 * Class IndexHelper.
 *
 * @package Mollie\Infrastructure\ORM\Utility
 */
class IndexHelper
{
    /**
     * Helper method that makes a simple map of properties and index numbers
     *
     * @param Entity $entity Entity whose indexes are mapped
     *
     * @return array Map of property indexes
     */
    public static function mapFieldsToIndexes(Entity $entity)
    {
        $result = array();
        $config = $entity->getConfig();
        $index = 1;
        foreach ($config->getIndexMap()->getIndexes() as $item) {
            $result[$item->getProperty()] = $index++;
        }

        return $result;
    }

    /**
     * Transforms entity fields from int, double, date, bool to their string representation for indexes
     *
     * @param Entity $entity
     *
     * @return string[]
     */
    public static function transformFieldsToIndexes(Entity $entity)
    {
        $result = array();
        $config = $entity->getConfig();
        $index = 1;
        foreach ($config->getIndexMap()->getIndexes() as $item) {
            $field = $item->getProperty();
            $result[$index++] = static::castFieldValue($entity->getIndexValue($field), $item->getType());
        }

        return $result;
    }

    /**
     * Casts value to index required string format
     *
     * @param mixed $value Raw value
     * @param string $type Type of the value
     *
     * @return string | null
     */
    public static function castFieldValue($value, $type)
    {
        if ($value === null || is_string($value)) {
            return $value;
        }

        if ($type === 'dateTime' && $value instanceof DateTime) {
            return (string)$value->getTimestamp();
        }

        if ($type === 'integer' && is_int($value)) {
            return sprintf('%011d', $value);
        }

        if ($type === 'double' && is_float($value)) {
            // 123.15 => 00000000123.15000, padding to 11 numbers before and padding to 5 behind decimal point
            return sprintf('%017.5f', $value);
        }

        if ($type === 'boolean' && is_bool($value)) {
            return $value ? '1' : '0';
        }

        if ($type === 'array' && is_array($value)) {
            return array_values($value);
        }

        return null;
    }
}
