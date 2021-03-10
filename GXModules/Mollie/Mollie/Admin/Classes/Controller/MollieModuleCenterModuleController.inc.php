<?php

use Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException;
use Mollie\BusinessLogic\MaintenanceMode\MaintenanceModeService;
use Mollie\BusinessLogic\Notifications\Model\Notification;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethodService;
use Mollie\BusinessLogic\VersionCheck\VersionCheckService;
use Mollie\Gambio\Mappers\OrderStatusMapper;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Gambio\Utility\MollieModuleChecker;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\Configuration\Configuration;
use Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException;
use Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException;
use Mollie\Infrastructure\ORM\RepositoryRegistry;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/../../../autoload.php';

/**
 * Class MollieModuleCenterModuleController
 */
class MollieModuleCenterModuleController extends AbstractModuleCenterModuleController
{

    /**
     * @var ConfigurationService
     */
    protected $configService;
    /**
     * @var PaymentMethodService
     */
    protected $paymentService;
    /**
     * @var \OrderStatusService
     */
    protected $orderStatusService;
    /**
     * @var VersionCheckService
     */
    protected $versionCheckService;
    /**
     * @var MaintenanceModeService
     */
    protected $maintenanceModeService;

    /**
     *
     */
    protected function _init()
    {
        $this->pageTitle              = $this->languageTextManager->get_text('mollie_title');
        $this->configService          = ServiceRegister::getService(Configuration::CLASS_NAME);
        $this->paymentService         = ServiceRegister::getService(PaymentMethodService::CLASS_NAME);
        $this->versionCheckService    = ServiceRegister::getService(VersionCheckService::CLASS_NAME);
        $this->maintenanceModeService = ServiceRegister::getService(MaintenanceModeService::CLASS_NAME);
        $this->orderStatusService     = StaticGXCoreLoader::getService('OrderStatus');
    }

    /**
     * Performs version checking and redirects to the mollie config page
     *
     * @return RedirectHttpControllerResponse
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
    public function actionDefault()
    {
        $this->versionCheckService->checkForNewVersion();
        $this->maintenanceModeService->checkMaintenanceMode();

        $redirectUrl = UrlProvider::generateAdminUrl('admin.php', 'MollieModuleCenterModule/Mollie');

        return MainFactory::create('RedirectHttpControllerResponse', $redirectUrl);
    }

    /**
     * Renders mollie config page
     *
     * @return AdminLayoutHttpControllerResponse
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    public function actionMollie()
    {
        $pageTitle = new NonEmptyStringType($this->pageTitle);
        $template  = PathProvider::getAdminTemplate('mollie_configuration.html');

        return MainFactory::create('AdminLayoutHttpControllerResponse',
            $pageTitle,
            $template,
            $this->_getTemplateData(),
            $this->_getAssets()
        );
    }

    /**
     * Returns assets collection for the module page
     *
     * @return AssetCollection
     */
    private function _getAssets()
    {
        $assetsArray = [
            MainFactory::create('Asset', UrlProvider::getPluginCssUrl('mollie_configuration.css')),
            MainFactory::create('Asset', UrlProvider::getPluginJavascriptUrl('mollie-notifications.js')),
            MainFactory::create('Asset', UrlProvider::getPluginJavascriptUrl('mollie-http.js')),
            MainFactory::create('Asset', UrlProvider::getPluginJavascriptUrl('mollie-connect.js')),
            MainFactory::create('Asset', UrlProvider::getPluginJavascriptUrl('mollie-config.js')),
        ];

        return MainFactory::create('AssetCollection', $assetsArray);
    }

    /**
     * Returns template data array
     *
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    private function _getTemplateData()
    {
        if (!MollieModuleChecker::isInstalled()) {
            return MainFactory::create('KeyValueCollection', []);
        }

        $isConnected = MollieModuleChecker::isConnected();
        $data = $this->_getRequiredData($isConnected);
        if ($isConnected) {
            $data = array_merge($data, $this->_getDataForConnectedProfile());
        }

        return MainFactory::create('KeyValueCollection', $data);
    }

    /**
     * Returns required data
     *
     * @param bool $isConnected
     *
     * @return array
     */
    private function _getRequiredData($isConnected)
    {
        $testToken = $this->configService->getTestApiKey();
        $liveToken = $this->configService->getLiveApiKey();

        return [
            'mollie_save_config_url'  => UrlProvider::generateAdminUrl('admin.php', 'MollieConfiguration'),
            'is_connected'            => $isConnected,
            'test_token'              => $testToken,
            'live_token'              => $liveToken,
            'version'                 => $this->configService->getExtensionVersion(),
            'is_test'                 => $this->configService->isTestMode(),
            'modules_url'             => UrlProvider::generateAdminUrl('admin.php', 'ModuleCenter'),
        ];
    }

    /**
     * Returns data when the user is connected
     *
     * @return array
     * @throws HttpAuthenticationException
     * @throws HttpCommunicationException
     * @throws UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    private function _getDataForConnectedProfile()
    {
        $paymentMethods = [];
        if ($websiteProfile = $this->configService->getWebsiteProfile()) {
            $paymentMethods = $this->paymentService->getAllPaymentMethodConfigurations($websiteProfile->getId());
        }

        $statusMapping = new OrderStatusMapper();


        return [
            'methods'                 => $this->_formatPaymentMethod($paymentMethods),
            'is_test'                 => $this->configService->isTestMode(),
            'notification_page_count' => $this->_getNumberOfNotificationPages(),
            'notification_url'        => UrlProvider::generateAdminUrl('admin.php', 'MollieNotification'),
            'order_statuses'          => $this->_formatOrderStatuses(),
            'saved_statuses'          => array_map('intval', $statusMapping->getStatusMap()),
        ];
    }

    /**
     * Formats payment method for rendering
     *
     * @param PaymentMethodConfig[] $paymentMethodConfigs
     *
     * @return array
     */
    private function _formatPaymentMethod(array $paymentMethodConfigs)
    {
        $methodsFormatted = [];
        foreach ($paymentMethodConfigs as $methodConfig) {
            $originalConfig     = $methodConfig->getOriginalAPIConfig();
            $id = $originalConfig->getId();
            $methodsFormatted[] = [
                'id'          => $originalConfig->getId(),
                'label'       => $originalConfig->getDescription(),
                'image_src'   => $originalConfig->getImage()->getSvg(),
                'is_enabled'  => $methodConfig->isEnabled(),
                'is_active'   => $this->_isMethodActive($id),
                'module_link' => UrlProvider::generateAdminUrl('modules.php', null, ['set' => 'payment', 'module' => "mollie_{$originalConfig->getId()}"])
            ];
        }

        return $methodsFormatted;
    }

    /**
     * Retunrs total number of notification pages
     *
     * @return int
     * @throws \Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException
     */
    private function _getNumberOfNotificationPages()
    {
        $repository = RepositoryRegistry::getRepository(Notification::getClassName());
        $totalNotifications = $repository->count();

        return ((int)($totalNotifications / MollieNotificationController::NOTIFICATIONS_PER_PAGE)) + 1;
    }

    /**
     * Formats order statuses for rendering
     *
     * @return array
     * @throws Exception
     */
    private function _formatOrderStatuses()
    {
        $formattedStatuses = [];
        $statuses = $this->orderStatusService->findAll();
        foreach ($statuses->getArray() as $status) {
            $formattedStatus['id'] = $status->getId();
            try {
                $formattedStatus['name'] = $status->getName(new LanguageCode(new StringType($_SESSION['language_code'])));
            } catch (InvalidArgumentException $exception) {
                $formattedStatus['name'] = $this->_getFallbackName($status);
            }

            $formattedStatuses[] = $formattedStatus;
        }

        return $formattedStatuses;
    }

    /**
     * Returns status name in the first available language
     *
     * @param OrderStatus $status
     *
     * @return string|null
     */
    private function _getFallbackName(OrderStatus $status)
    {
        foreach (xtc_get_languages() as $language) {
            try {
                return $status->getName(new LanguageCode(new StringType($language['code'])));
            } catch (Exception $exception) {
                continue;
            }
        }

        return '';
    }

    /**
     * Check if gambio payment module is active
     *
     * @param string $mollieId
     *
     * @return bool
     */
    private function _isMethodActive($mollieId)
    {
        $statusKey = 'MODULE_PAYMENT_MOLLIE_' . strtoupper($mollieId) . '_STATUS';

        return defined($statusKey) ?
            strtolower_wrapper(@constant($statusKey)) === 'true' : false;
    }
}
