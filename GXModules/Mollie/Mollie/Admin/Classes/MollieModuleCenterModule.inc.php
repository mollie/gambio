<?php

use Mollie\Gambio\Entity\Repository\GambioConfigRepository;
use Mollie\Gambio\Entity\Repository\GambioStatusRepository;


/**
 * Class MollieModuleCenterModule
 */
class MollieModuleCenterModule extends AbstractModuleCenterModule
{
    const ENTITY_TABLE            = 'mollie_entity';
    const MOLLIE_DEFAULT_STATUSES = 'MOLLIE_DEFAULT_ORDER_STATUSES_MAP';

    /**
     * @var array[]
     */
    private static $defaultStatuses = [
        'mollie_created'    => [
            'names' => [
                'en' => 'Created (Mollie)',
                'de' => 'Created (Mollie)',
            ],
            'color' => 'B0B0B0',
        ],
        'mollie_paid'       => [
            'names' => [
                'en' => 'Paid (Mollie)',
                'de' => 'Paid (Mollie)',
            ],
            'color' => '4BD562',
        ],
        'mollie_authorized' => [
            'names' => [
                'en' => 'Authorized (Mollie)',
                'de' => 'Authorized (Mollie)',
            ],
            'color' => 'F8B103',
        ],
        'mollie_refunded'   => [
            'names' => [
                'en' => 'Refunded (Mollie)',
                'de' => 'Refunded (Mollie)',
            ],
            'color' => '3075FA',
        ],

    ];

    /**
     * @var GambioStatusRepository
     */
    private $orderStatusRepository;
    /**
     * @var GambioConfigRepository
     */
    private $configRepository;

    /**
     * @inheritDoc
     */
    protected function _init()
    {
        require_once __DIR__ . '/../../autoload.php';

        $this->title              = $this->languageTextManager->get_text('mollie_title');
        $this->description        = $this->languageTextManager->get_text('mollie_description');
        $this->sortOrder          = 1;
        $this->orderStatusRepository          = new GambioStatusRepository();
        $this->configRepository          = new GambioConfigRepository();
    }

    /**
     * @inheritDoc
     */
    public function install()
    {
        $this->_createEntityTable();
        $this->_addIndexes();
        $this->_addOrderStatuses();

        parent::install();
    }

    /**
     * @inheritDoc
     */
    public function uninstall()
    {
        $this->_removeMollieData();

        parent::uninstall();
    }

    /**
     * Executes SQL script that creates mollie entity table
     */
    private function _createEntityTable()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . self::ENTITY_TABLE . '` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `type` VARCHAR(100) NOT NULL,
            `index_1` VARCHAR(255),
            `index_2` VARCHAR(255),
            `index_3` VARCHAR(255),
            `index_4` VARCHAR(255),
            `index_5` VARCHAR(255),
            `index_6` VARCHAR(255),
            `index_7` VARCHAR(255),
            `data` TEXT,
            PRIMARY KEY (`id`)
        )';

        $this->db->query($sql);
    }

    /**
     * Creates sql indexes
     */
    private function _addIndexes()
    {
        $this->_createIndex('mollie_index_type', 'type');
        for ($i = 1; $i <= 7; $i++) {
            $this->_createIndex("mollie_index_$i", "index_$i");
        }
    }

    /**
     * @param string $indexName
     * @param string $column
     */
    private function _createIndex($indexName, $column)
    {
        $this->db->query("CREATE INDEX `$indexName` ON `" . static::ENTITY_TABLE . "` (`$column`)");
    }

    /**
     * Removes mollie data from the database
     */
    private function _removeMollieData()
    {
        $this->db->query('DROP TABLE IF EXISTS `' . static::ENTITY_TABLE . '`');
    }

    /**
     *
     */
    private function _addOrderStatuses()
    {
        $mollieConfig = $this->configRepository->getMollieConfiguration();
        if (empty($mollieConfig)) {
            return;
        }

        $defaultStatusesMap = [];
        foreach (static::$defaultStatuses as $statusKey => $defaultStatus) {
            $id                             = $this->_createOrderStatus($defaultStatus['names'], $defaultStatus['color']);
            $defaultStatusesMap[$statusKey] = $id;
        }

        $sql = 'INSERT INTO ' . TABLE_CONFIGURATION .
            " (`key`, `value`) 
            VALUES ('configuration/" . static::MOLLIE_DEFAULT_STATUSES . "', '" . json_encode($defaultStatusesMap) . "')";

        $this->db->query($sql);
    }

    /**
     * @param array  $names
     * @param string $color
     *
     * @return int
     */
    private function _createOrderStatus($names, $color)
    {
        $newStatus = [];
        foreach ($names as $languageCode => $statusName) {
            $newStatus[] = [
                'language_id' => $this->_getLanguageId($languageCode),
                'orders_status_name' => $statusName,
                'color' => $color,
            ];
        }
        return $this->orderStatusRepository->insertStatus($newStatus);
    }

    /**
     * @param string $code
     *
     * @return int
     */
    private function _getLanguageId($code)
    {
        $languages = xtc_get_languages();
        foreach ($languages as $language) {
            if ($language['code'] === $code) {
                return (int)$language['id'];
            }
        }

        return 1;
    }
}
