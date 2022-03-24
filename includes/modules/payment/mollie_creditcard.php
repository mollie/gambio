<?php

use Mollie\BusinessLogic\CustomerReference\CustomerReferenceService;
use Mollie\BusinessLogic\Customer\CustomerService;
use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\Gambio\Entity\Repository\GambioConfigRepository;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\Http\Exceptions\HttpRequestException;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_ccard
 */
class mollie_creditcard extends mollie
{
    const  GUEST_STATUS_ID = '1';
    public $title = 'Credit card';

    public function __construct()
    {
        parent::__construct();

        $componentsKey = $this->_formatKey('COMPONENTS_STATUS');
        $singleClickKey = $this->_formatKey('SINGLE_CLICK_STATUS');
        $useComponents = @constant($componentsKey);
        $useSingleClick = @constant($singleClickKey);
        if (empty($useComponents) && $this->_isInstalled()) {
            $this->setInitialMollieComponentsUsage($this->_formatKey('COMPONENTS_STATUS', true));
            define($componentsKey, 'true');
        }

        if (empty($useSingleClick) && $this->_isInstalled()) {
            $this->setInitialMollieComponentsUsage($this->_formatKey('SINGLE_CLICK_STATUS', true));
            define($singleClickKey, 'true');
        }
    }

    /**
     * @return array|bool
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     */
    public function selection()
    {
        $selection = parent::selection();
        if (!$selection) {
            return false;
        }

        $configKey = $this->_formatKey('COMPONENTS_STATUS');
        if (@constant($configKey) === 'true') {
            $selection['fields'] = [
                [
                    'title' => $this->_renderCreditCardInfo(),
                    'field' => '',
                ]
            ];
        }

        return $selection;
    }

    /**
     * @inheritDoc
     * @return string
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws HttpRequestException
     * @throws UnprocessableEntityRequestException
     */
    public function process_button()
    {
        if (!empty($_POST['mollieCardToken'])) {
            $_SESSION['mollie_card_token'] = $_POST['mollieCardToken'];
        }

        $statusOfSaveCreditCard = $_POST['mollie_creditcard-save-credit-card-checkbox'];
        $statusOfUseSavedCreditCard = $_POST['mollie_creditcard-use-saved-credit-card-checkbox'];

        if ($statusOfSaveCreditCard === 'on' && $statusOfUseSavedCreditCard === null) {
            $customerId = $_SESSION['customer_id'];
            $_SESSION['mollie_customer_id'] = $this->getCustomerService()->createCustomer($this->getCurrentCustomer(),
                (string)$customerId);
        }

        if ($statusOfUseSavedCreditCard === 'on') {
            $this->setExistingMollieReferece();

            if (!empty($_SESSION['mollie_card_token'])) {
                unset($_SESSION['mollie_card_token']);
            }
        }

        return parent::process_button();
    }

    /**
     * @return void
     */
    protected function setExistingMollieReferece()
    {
        $customer = $this->getCustomerReferenceService()->getByShopReference($_SESSION['customer_id']);

        if ($customer) {
            $_SESSION['mollie_customer_id'] = $customer->getMollieReference();
        }
    }

    /**
     * @return \Mollie\BusinessLogic\Http\DTO\Customer
     */
    protected function getCurrentCustomer()
    {
        $customer = new Mollie\BusinessLogic\Http\DTO\Customer();
        $customer->setName($_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name']);
        $customer->setEmail($_SESSION['gm_heidelpay_email_address']);

        return $customer;
    }

    protected function _getHiddenFields()
    {
        $fields = parent::_getHiddenFields();
        $fields ['SINGLE_CLICK_APPROVAL_TEXT'] = [
            'value' => $this->translate($_SESSION['language_code'], 'mollie_single_click_payment_approval_text'),
        ];
        $fields ['SINGLE_CLICK_DESCRIPTION'] = [
            'value' => $this->translate($_SESSION['language_code'], 'mollie_single_click_payment_desc'),
        ];

        foreach (xtc_get_languages() as $language) {
            $code = strtoupper($language['code']);
            $fields['SINGLE_CLICK_APPROVAL_TEXT_' . $code] = [
                'value' => $this->translate($code, 'mollie_single_click_payment_approval_text'),
            ];
            $fields['SINGLE_CLICK_DESCRIPTION_' . $code] = [
                'value' => $this->translate($code, 'mollie_single_click_payment_desc'),
            ];
        }

        return $fields;
    }

    /**
     * @return CustomerReferenceService
     */
    protected function getCustomerReferenceService()
    {
        /** @var CustomerReferenceService $customerReferenceService */
        $customerReferenceService = ServiceRegister::getService(CustomerReferenceService::CLASS_NAME);

        return $customerReferenceService;
    }

    /**
     * @return CustomerService
     */
    protected function getCustomerService()
    {
        /** @var CustomerService $customerService */
        $customerService = ServiceRegister::getService(CustomerService::CLASS_NAME);

        return $customerService;
    }

    /**
     * @return string|string[]
     * @throws Exception
     */
    private function _renderCreditCardInfo()
    {
        /** @var \Mollie\Gambio\Services\Business\ConfigurationService $configService */
        $configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        $template = PathProvider::getShopTemplatePath('mollie_credit_card.html');

        $currentLanguage = $_SESSION['language_code'];
        $countryCode = $currentLanguage === 'en' ? 'US' : strtoupper($currentLanguage);
        $lang = $currentLanguage . '_' . $countryCode;
        $profileId = $configService->getWebsiteProfile() ? $configService->getWebsiteProfile()->getId() : null;

        $renderSaveCreditCardCheckbox = false;
        $renderUseSavedCreditCardCheckbox = false;
        $customerStatusId = $_SESSION['customers_status']['customers_status_id'];
        if ($customerStatusId !== self::GUEST_STATUS_ID &&
            @constant($this->_formatKey('SINGLE_CLICK_STATUS')) === 'true')
        {
            $customerFromDb = $this->getCustomerReferenceService()->getByShopReference($_SESSION['customer_id']);
            if (!$customerFromDb) {
                $renderSaveCreditCardCheckbox = true;
            } else {
                $renderUseSavedCreditCardCheckbox = true;
            }
        }

        return mollie_render_template(
            $template,
            [
                'profile_id' => $profileId,
                'test_mode' => $configService->isTestMode(),
                'lang' => $lang,
                'payment_method' => $this->code,
                'renderSaveCheckBox' => $renderSaveCreditCardCheckbox,
                'approvalText' => @constant($this->_formatKey('SINGLE_CLICK_APPROVAL_TEXT')),
                'renderUseSavedCheckbox' => $renderUseSavedCreditCardCheckbox,
                'descriptionText' => @constant($this->_formatKey('SINGLE_CLICK_DESCRIPTION'))
            ]
        );
    }

    /**
     * @param $key
     */
    private function setInitialMollieComponentsUsage($key)
    {
        $repository = new GambioConfigRepository();
        $insert = $this->getComponentsConfig();
        $insert['key'] = $key;
        $insert['sort_order'] = 0;

        $repository->insert($insert);
    }

    /**
     * @return string[]
     */
    private function getComponentsConfig()
    {
        return [
            'value' => 'true',
            'type' => 'switcher',
        ];
    }
}