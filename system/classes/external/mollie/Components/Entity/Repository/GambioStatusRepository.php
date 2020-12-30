<?php


namespace Mollie\Gambio\Entity\Repository;

/**
 * Class GambioStatusRepository
 *
 * @package Mollie\Gambio\Entity\Repository
 */
class GambioStatusRepository extends GambioBaseRepository
{

    /**
     * Returns all order status in format
     * [$statusId => ['id', 'names','color']]
     *
     * @return array
     */
    public function getAllStatuses()
    {
        $results = $this->getAll();
        $statuses = [];
        foreach ($results as $result) {
            $id = $result[$this->_getIdentifierKey()];
            $statuses[$id]['id'] = $id;
            $statuses[$id]['names'][$result['language_id']] = $result['orders_status_name'];
            $statuses[$id]['color'] = $result['color'];
        }

        return $statuses;
    }

    /**
     * @param array $insertPayload
     *
     * @return string
     */
    public function insertStatus($insertPayload)
    {
        $id = $this->_getNextStatusID();
        foreach ($insertPayload as $row) {
            $row[$this->_getIdentifierKey()] = $id;
            $this->queryBuilder->insert($this->_getTableName(), $row);
        }

        return $id;
    }

    /**
     * @return int
     */
    private function _getNextStatusID()
    {
        $result = $this->queryBuilder->select('max(orders_status_id) as freeId')->get($this->_getTableName())->first_row('array');
        if (empty($result['freeId'])) {
            return 1;
        }

        return (int)$result['freeId'] + 1;
    }

    /**
     * @inheritDoc
     */
    protected function _getTableName()
    {
        return TABLE_ORDERS_STATUS;
    }

    /**
     * @inheritDoc
     */
    protected function _getIdentifierKey()
    {
        return 'orders_status_id';
    }
}