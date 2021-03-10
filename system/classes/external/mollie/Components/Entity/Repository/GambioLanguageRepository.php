<?php

namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioLanguageRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioLanguageRepository extends GambioBaseRepository
{

    CONST TABLE_NAME = 'languages';

    /**
     * Fetched all languages from store
     *
     * @return array
     */
    public function getLanguages()
    {
        return $this->queryBuilder->select()
            ->select('languages_id AS id')
            ->order_by('sort_order ASC')
            ->get('languages')
            ->result_array();
    }

    /**
     * @inheritDoc
     */
    protected function _getTableName()
    {
        return static::TABLE_NAME;
    }

    /**
     * @inheritDoc
     */
    protected function _getIdentifierKey()
    {
        return 'languages_id';
    }
}
