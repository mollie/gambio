<?php

use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\Gambio\APIProcessor\ProcessorFactory;
use Mollie\Gambio\Entity\Repository\GambioConfigRepository;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Gambio\Utility\MollieModuleChecker;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Logger\Logger;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/../../../../GXModules/Mollie/Mollie/autoload.php';
include_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/mollie_config_fields.php';

/**
 * Class mollie
 */
class mollie
{
    public $code;
    public $title;
    public $description;
    public $enabled;
    public $sort_order;
    public $info;
    public $logoUrl   = '';
    public $tmpOrders = true;
    public $tmpStatus = 0;

    /**
     * Title label, without prepended img element
     *
     * @var string
     */
    protected $titleLabel;

    protected static $isMollieInstalled;
    protected static $enabledOnMollie;
    protected static $allMolliePaymentMethods;

    /**
     * mollie constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        global $order;
        $this->code = get_class($this);

        include(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/payment/' . $this->code . '.php');


        $this->title = @constant($this->_formatKey('TEXT_TITLE')) ?: $this->title;
        $this->titleLabel = $this->title;

        $this->title = $this->_prependLogo("/images/icons/payment/{$this->code}.png", $this->title);

        $this->sort_order = @constant($this->_formatKey('SORT_ORDER'));
        $this->enabled    = @constant($this->_formatKey('STATUS')) === 'true';

        $this->description = $this->_renderDescription($order);
    }

    /**
     * Not used
     */
    public function update_status()
    {
        return false;
    }

    /**
     * Not used
     *
     * @return boolean
     */
    public function javascript_validation()
    {
        return false;
    }

    /**
     * Provides entry for list of available payment modules on checkout_payment
     *
     * @return array|bool
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     */
    public function selection()
    {
        global $order;
        if (!$this->_isAvailable($order)) {
            return false;
        }

        $currentLang = strtoupper($_SESSION['language_code']);
        $imageUrl    = $this->_getMethodLogo();
        $surcharge   = $this->_getSurchargeValue();
        $descriptionLabel = stripslashes(@constant($this->_formatKey('CHECKOUT_DESCRIPTION_' . $currentLang)));

        $selection = [
            'id'          => $this->code,
            'module'      => stripslashes(@constant($this->_formatKey('CHECKOUT_NAME_' . $currentLang))),
            'description' => $this->_prependLogo($imageUrl, $descriptionLabel),
            'logo_url'    => $imageUrl,
            'logo_alt'    => $this->titleLabel,
        ];

        if (!empty($surcharge) && $this->_otMollieEnabled()) {
            $selection['module_cost'] = '+ ' . number_format((float)$surcharge, 2) . ' ' . $order->info['currency'];
        }

        return $selection;
    }

    /**
     * Hook called by checkout_confirmation
     */
    public function pre_confirmation_check()
    {
        return false;
    }

    /**
     * Provides information for checkout_confirmation page
     *
     * @return bool
     */
    public function confirmation()
    {
        return false;
    }

    /**
     * Not used
     *
     * @return string
     */
    public function process_button()
    {
        return '';
    }

    /**
     * Not used
     *
     * @return boolean
     */
    public function before_process()
    {
        return false;
    }

    /**
     * Handles payment action
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function payment_action()
    {
        global $insert_id;

        $this->_setOriginalConfig();
        $processor = ProcessorFactory::createProcessor($this->code);

        $result      = $processor->create($insert_id);
        $redirectUrl = $result->isSuccess() ? $result->getRedirectUrl() : xtc_href_link('checkout_payment.php', 'payment_error=' . $this->code);
        if (!$result->isSuccess()) {
            $_SESSION[$this->code . '_error'] = $result->getErrorMessage();
        }

        xtc_redirect($redirectUrl, '');
    }

    /**
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function after_process()
    {
        global $insert_id;
        if ($this->order_status) {
            xtc_db_query("UPDATE " . TABLE_ORDERS . " SET orders_status='" . $this->order_status . "' WHERE orders_id='" . $insert_id . "'");
        }
    }

    /**
     * Returns error message (if any) for displaying on checkout_payment
     *
     * @return boolean|array
     */
    public function get_error()
    {
        $error      = false;
        $errorIndex = $this->code . '_error';
        if (isset($_SESSION[$errorIndex])) {
            $error = [
                'title' => $this->titleLabel . ' error',
                'error' => $_SESSION[$errorIndex],
            ];
            unset($_SESSION[$errorIndex]);
        }

        return $error;
    }

    /**
     * Check module's status
     *
     * @return bool
     */
    public function check()
    {
        if (!isset ($this->_check)) {
            $key          = $this->_formatKey('STATUS', true);
            $check_query  = xtc_db_query('SELECT `value` FROM ' . GambioConfigRepository::TABLE_NAME . " WHERE `key` = '$key'");
            $this->_check = xtc_db_num_rows($check_query);
        }

        return $this->_check;
    }

    /**
     * Install the payment module
     *
     * This will also install three new order statuses and pre-configure the module for their use.
     */
    public function install()
    {
        $config      = $this->_configuration();
        $sortOrder   = 0;
        $configGroup = 6;

        foreach ($config as $key => $data) {
            $key = $this->_formatKey($key, true);
            $type = array_key_exists('type', $data) ? $data['type'] : '';
            $sql = 'INSERT INTO ' . GambioConfigRepository::TABLE_NAME . ' ' .
                '( `key`, `value`,  `type`, `legacy_group_id`, `sort_order`) ' .
                "VALUES ('" . $key . "', '" . xtc_db_input($data['value']) . "', '" . $type . "', '" . $configGroup . "', '" . $sortOrder . "')";

            xtc_db_query($sql);
        }
    }

    /**
     * Deletes the payment method's configuration from the database
     */
    public function remove()
    {
        $keys = $this->_getAllKeys($this->_configuration());
        xtc_db_query('DELETE FROM ' . GambioConfigRepository::TABLE_NAME . " where `key` in ('" . implode("', '", $keys) . "')");
    }

    /**
     * Determines the module's configuration keys
     *
     * @return array
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function keys()
    {
        $keys         = $this->_getAllKeys($this->_configuration());
        $hiddenFields = $this->_getAllKeys($this->_getHiddenFields());
        if (!$this->_otMollieEnabled()) {
            $hiddenFields[] = $this->_formatKey('SURCHARGE', true);
        }

        return array_values(array_diff($keys, $hiddenFields));
    }

    /**
     * Return payment method configuration fields with default rendering options
     *
     * @return string[][]
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function _configuration()
    {
        $baseConfig = [
            'STATUS'               => [
                'value' => 'true',
                'type'  => 'switcher',
            ],
            'SURCHARGE'            => [
                'value' => '0',
            ],
            'SORT_ORDER'           => [
                'value' => '0',
            ],
        ];

        return array_merge($baseConfig, $this->_getHiddenFields());
    }

    /**
     * Return config fields which has custom rendering options
     *
     * @return array
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    protected function _getHiddenFields()
    {
        $method         = $this->_getCurrentMollieMethod();
        $originalConfig = $method ? $method->toArray() : [];
        $name           = $method ? $method->getDescription() : $this->titleLabel;
        $fields         = [
            'ORIGINAL_CONFIG' => [
                'value' => json_encode($originalConfig),
            ],
            'ALLOWED'         => [
                'value' => '',
            ],
            'TEXT'            => [
                'value' => $name,
            ],
            'LOGO'            => [
                'value' => UrlProvider::generateShopUrl("images/icons/payment/{$this->code}.png"),
            ],
            'API_METHOD'      => [
                'value' => $this->_getDefaultApi(),
            ],
            'ALLOWED_ZONES'   => [
                'value' => '',
            ],
            'CHECKOUT_NAME'   =>  [
                'value' => $name
            ],
            'CHECKOUT_DESCRIPTION'   =>  [
                'value' => $this->translate($_SESSION['language_code'], 'mollie_checkout_desc'),
            ],
            'ORDER_EXPIRES' => [
                'value' => null,
            ],
            'TRANSACTION_DESCRIPTION'   =>  [
                'value' => '{orderNumber}',
            ],
        ];

        foreach (xtc_get_languages() as $language) {
            $code                             = strtoupper($language['code']);
            $fields['CHECKOUT_NAME_' . $code] = [
                'value' => $name,
            ];

            $fields['CHECKOUT_DESCRIPTION_' . $code] = [
                'value' => $this->translate($code, 'mollie_checkout_desc'),
            ];

            $fields['TRANSACTION_DESCRIPTION_' . $code] = [
                'value' => '{orderNumber}',
            ];
        }

        return $fields;
    }

    /**
     * Renders payment method description
     *
     * @return string|string[]
     * @throws Exception
     */
    protected function _renderDescription($order)
    {
        $descPath = PathProvider::getAdminTemplatePath('description.html', 'PaymentMethod');
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $data          = [
            'payment_code'     => $this->code,
            'payment_label'    => stripslashes(@constant($this->_formatKey('TEXT_TITLE'))),
            'version'          => $configService->getExtensionVersion(),
            'is_connected'     => MollieModuleChecker::isConnected(),
            'is_method_active' => $this->_isMethodEnabled($order),
            'logo_path'        => $this->_getMethodLogo(),
            'is_installed'     => MollieModuleChecker::isInstalled(),
            'css_folder'       => UrlProvider::getPluginCssUrl(''),
            'plugin_url'       => UrlProvider::generateAdminUrl('admin.php', 'MollieModuleCenterModule'),

            'plugin_not_installed_url' => UrlProvider::generateAdminUrl('admin.php', 'ModuleCenter'),
        ];

        return mollie_render_template($descPath, $data);
    }

    /**
     * Set original payment method configuration (if not already set in the config table)
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    protected function _setOriginalConfig()
    {
        $key            = $this->_formatKey('ORIGINAL_CONFIG');
        $originalConfig = json_decode(@constant($key), true);
        if (empty($originalConfig)) {
            $config = $this->_getCurrentMollieMethod()->toArray();
            $sql    = 'UPDATE ' . GambioConfigRepository::TABLE_NAME . " 
                    SET `value` = '" . json_encode($config) . "'
                    WHERE `key` = 'configuration/" . $key . "'";
            xtc_db_query($sql);
        }
    }


    /**
     * Check if method enabled on Mollie
     *
     * @return bool
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     */
    protected function _isMethodEnabled($order)
    {
        if (!$this->_isMollieInstalled()) {
            return false;
        }

        try {
            $originalCode   = substr($this->code, strlen('mollie_'));
            $enabledMethods = $this->_getEnabledMethodsMap($order);

            return array_key_exists($originalCode, $enabledMethods);
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @param array $baseArray
     *
     * @return array
     */
    protected function _getAllKeys(array $baseArray)
    {
        $configKeys = array_keys($baseArray);
        $keys       = [];
        foreach ($configKeys as $key) {
            $keys[] = $this->_formatKey($key, true);
        }

        return $keys;
    }

    /**
     * Return flag that indicates whether is payment method available on checkout
     *
     * @param $order
     *
     * @return bool
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     */
    protected function _isAvailable($order)
    {
        if (!MollieModuleChecker::isInstalled()) {
            return false;
        }

        $billing            = $order->billing;
        $zonesKey           = $this->_formatKey('ALLOWED_ZONES');
        $availableCountries = @constant($zonesKey);
        if (!empty($availableCountries)) {
            $availableCountries = explode(',', $availableCountries);
            if (!in_array(strtoupper($billing['country']['iso_code_2']), $availableCountries, true)) {
                return false;
            }
        }

        return $this->_isMethodEnabled($order);
    }

    /**
     * @param object $order
     *
     * @return mixed
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    protected function _getEnabledMethodsMap($order)
    {
        if (!isset(static::$enabledOnMollie)) {
            $billingCountry = null;
            $amount         = null;
            if ($order->info) {
                $amount = new Amount();
                $amount->setAmountValue($order->info['total']);
                $amount->setCurrency($order->info['currency']);
            }

            if (is_array($order->billing['country'])) {
                $billingCountry = $order->billing['country']['iso_code_2'];
            }

            /** @var Proxy $proxy */
            $proxy                   = ServiceRegister::getService(Proxy::CLASS_NAME);
            static::$enabledOnMollie = $proxy->getEnabledPaymentMethodsMap($billingCountry, $amount);
        }

        return static::$enabledOnMollie;
    }

    /**
     * @return \Mollie\BusinessLogic\Http\DTO\PaymentMethod|null
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    protected function _getCurrentMollieMethod()
    {
        if (!$this->_isMollieInstalled()) {
            return null;
        }

        $allMethods = $this->_getAllPaymentMethods();

        return array_key_exists($this->code, $allMethods) ? $allMethods[$this->code] : null;
    }

    /**
     * @return array
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    protected function _getAllPaymentMethods()
    {
        if (!isset(static::$allMolliePaymentMethods)) {
            static::$allMolliePaymentMethods = $this->_getMollieMethodsMap();
        }

        return static::$allMolliePaymentMethods;
    }

    /**
     * @return array
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    private function _getMollieMethodsMap()
    {
        $map = [];
        try {
            /** @var Proxy $proxy */
            $proxy         = ServiceRegister::getService(Proxy::CLASS_NAME);
            $sourceMethods = $proxy->getAllPaymentMethods();
            $map           = [];
            foreach ($sourceMethods as $sourceMethod) {
                $map['mollie_' . $sourceMethod->getId()] = $sourceMethod;
            }

        } catch (Exception $exception) {
            Logger::logWarning("Couldn't fetch payment methods from Mollie API: {$exception->getMessage()}");
        }

        return $map;
    }

    /**
     * @return string
     */
    protected function _getMethodLogo()
    {
        $constantKey = $this->_formatKey('LOGO');
        $imagePath   = defined($constantKey) ? @constant($constantKey) : null;

        $defaultImagePath = UrlProvider::generateShopUrl("images/icons/payment/{$this->code}.png");

        return !empty($imagePath) ? $imagePath : $defaultImagePath;
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected function _isMollieInstalled()
    {
        if (!isset(static::$isMollieInstalled)) {
            static::$isMollieInstalled = MollieModuleChecker::isInstalled();
        }

        return static::$isMollieInstalled;
    }

    /**
     * @return string
     */
    protected function _getDefaultApi()
    {
        return PaymentMethodConfig::API_METHOD_PAYMENT;
    }

    /**
     * Checks whether ot_mollie module is enabled
     *
     * @return bool
     */
    protected function _otMollieEnabled()
    {
        return defined('MODULE_ORDER_TOTAL_MOLLIE_STATUS') ?
            strtolower(MODULE_ORDER_TOTAL_MOLLIE_STATUS) === 'true' : false;
    }

    /**
     * Returns fully formatted key
     *
     * @param string $key
     * @param bool $addPrefix
     *
     * @return string
     */
    protected function _formatKey($key, $addPrefix = false)
    {
        $code = strtoupper($this->code);
        $constantKey = "MODULE_PAYMENT_{$code}_{$key}";

        return $addPrefix ? "configuration/$constantKey" : $constantKey;
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
        $languages = xtc_get_languages();
        foreach ($languages as $language) {
            if ($language['code'] === strtolower($langCode)) {
                return $language['id'];
            }
        }

        // default language as fallback
        return 0;
    }

    /**
     * Prepends image element to the given label
     *
     * @param string $imageUrl
     * @param string $label
     *
     * @return string
     * @throws Exception
     */
    protected function _prependLogo($imageUrl, $label)
    {
        /** @var ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        if (version_compare($configService->getIntegrationVersion(), 'v3.9.0', 'lt')) {
            $label = mollie_get_payment_logo($this->code, $imageUrl) . $label;
        }

        return $label;
    }

    /**
     * Returns surcharge with tax included
     *
     * @return float
     */
    protected function _getSurchargeValue()
    {
        $surcharge = @constant($this->_formatKey('SURCHARGE'));
        if (defined('MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS')) {
            $taxRate = xtc_get_tax_rate(MODULE_ORDER_TOTAL_MOLLIE_TAX_CLASS);
            if ($taxRate) {
                return xtc_add_tax($surcharge, $taxRate);
            }
        }

        return $surcharge;
    }

    /**
     * Check if module installed
     *
     * @return bool
     */
    protected function _isInstalled()
    {
        $statusKey = $this->_formatKey('STATUS');

        return defined($statusKey);
    }
}

MainFactory::load_origin_class('mollie');
