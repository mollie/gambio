<?php

namespace Mollie\Gambio\Update\v2_0_8;

use LanguageTextManager;
use Mollie\BusinessLogic\Surcharge\SurchargeType;
use Mollie\Gambio\Entity\Repository\GambioConfigRepository;
use Mollie\Gambio\Entity\Repository\GambioLanguageRepository;
use StaticGXCoreLoader;

/**
 * Class PaymentMethodUpdate
 *
 * @package Mollie\Gambio\Update\v2_0_8
 */
class PaymentMethodUpdate
{

    CONST TRANSACTION_DESC_DEFAULT_VALUE = '{orderNumber}';

    /**
     * @var string
     */
    private $code;
    /**
     * @var bool
     */
    private $isInstalled;

    /**
     * PaymentMethodUpdate constructor.
     *
     * @param string $code
     * @param bool $isInstalled
     */
    public function __construct($code, $isInstalled)
    {
        $this->code = $code;
        $this->isInstalled = $isInstalled;
    }

    /**
     * Adds missing fields if the methods is already installed
     */
    public function addConfigFields()
    {
        if (!$this->isInstalled) {
            return;
        }

        $this->addCommonFields();
    }

    /**
     * Adds common methods fields
     */
    private function addCommonFields()
    {
        foreach ($this->getCommonFields() as $configOptions) {
            $configKey = $this->_formatKey($configOptions['key']);
            if (!defined($configKey)) {
                $this->insertConfig($configOptions);
                define($configKey, $configOptions['value']);
            }
        }
    }

    /**
     * Insert given options to the configuration table
     *
     * @param array $options
     */
    private function insertConfig($options)
    {
        $repository = new GambioConfigRepository();

        $insert['configuration_key'] = $this->_formatKey($options['key']);
        $insert['configuration_value'] = xtc_db_input($options['value']);
        $insert['configuration_group_id'] = 6;
        $insert['set_function'] = xtc_db_input($options['set_function']);
        $insert['sort_order'] = 0;

        $repository->insert($insert);
    }

    /**
     * Returns fully formatted key
     *
     * @param string $key
     *
     * @return string
     */
    protected function _formatKey($key)
    {
        $code = strtoupper($this->code);

        return "MODULE_PAYMENT_{$code}_{$key}";
    }

    /**
     * Returns all common fields that should be updated
     *
     * @return array
     */
    protected function getCommonFields()
    {
        $configFields = [
            [
                'key' => 'ORDER_EXPIRES',
                'value' => null,
                'set_function' => 'mollie_input_integer( ',
            ],
            [
                'key' => 'TRANSACTION_DESCRIPTION',
                'value' => static::TRANSACTION_DESC_DEFAULT_VALUE,
                'set_function' => 'mollie_multi_language_text( ',
            ],
            [
                'key' => 'SURCHARGE_TYPE',
                'value' => SurchargeType::NO_FEE,
                'set_function' => 'mollie_surcharge_type_select( ',
            ],
            [
                'key' => 'SURCHARGE_FIXED_AMOUNT',
                'value' => 0,
                'set_function' => 'mollie_input_number( ',
            ],
            [
                'key' => 'SURCHARGE_PERCENTAGE',
                'value' => 0,
                'set_function' => 'mollie_input_number( ',
            ],
            [
                'key' => 'SURCHARGE_LIMIT',
                'value' => 0,
                'set_function' => 'mollie_input_number( ',
            ]
        ];

        $languageRepository = new GambioLanguageRepository();
        foreach ($languageRepository->getLanguages() as $language) {
            $code = strtoupper($language['code']);
            $configFields[] = [
                'key' => 'TRANSACTION_DESCRIPTION_' . $code,
                'value' => static::TRANSACTION_DESC_DEFAULT_VALUE,
            ];
        }

        if($this->code === 'mollie_creditcard')
        {
            $configFields[] = [
                'key' => 'SINGLE_CLICK_APPROVAL_TEXT',
                'value' => $this->translate($_SESSION['language_code'], 'mollie_single_click_payment_approval_text'),
                'set_function' => 'mollie_multi_language_text( ',
            ];

            $configFields[] = [
                'key' => 'SINGLE_CLICK_DESCRIPTION',
                'value' => $this->translate($_SESSION['language_code'], 'mollie_single_click_payment_desc'),
                'set_function' => 'mollie_multi_language_text( ',
            ];

            foreach ($languageRepository->getLanguages() as $language) {
                $code = strtoupper($language['code']);
                $configFields[] = [
                    'key' => 'SINGLE_CLICK_APPROVAL_TEXT_' . $code,
                    'value' => $this->translate($code, 'mollie_single_click_payment_approval_text'),
                ];
                $configFields[] = [
                    'key' => 'SINGLE_CLICK_DESCRIPTION_' . $code,
                    'value' => $this->translate($code, 'mollie_single_click_payment_desc'),
                ];
            }
        }

        return $configFields;
    }

    /**
     * Retruns translated phrase
     *
     * @param string $langCode
     * @param string $phrase
     *
     * @return string
     */
    protected function translate($langCode, $phrase)
    {
        return LanguageTextManager::get_instance('module_center_module', $this->_getLanguageId($langCode))->get_text($phrase);
    }

    /**
     * Returns language id based on lang code
     *
     * @param string $langCode
     *
     * @return int
     */
    protected function _getLanguageId($langCode)
    {
        $languages = $this->_getLanguages();
        foreach ($languages as $language) {
            if ($language['code'] === strtolower($langCode)) {
                return $language['id'];
            }
        }

        // default language as fallback
        return 0;
    }

    protected function _getLanguages()
    {
        $db = StaticGXCoreLoader::getDatabaseQueryBuilder();
        $languages = $db->select('*')
            ->select('languages_id AS id')
            ->order_by('sort_order ASC')
            ->get('languages')
            ->result_array();
        return $languages;
    }
}

