<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\BusinessLogic\Http\DTO\PaymentMethod;
use Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig;
use Mollie\BusinessLogic\PaymentMethod\PaymentMethodService as BaseService;
use Mollie\Gambio\Entity\Repository\GambioConfigRepository;

/**
 * Class PaymentService
 *
 * @package Mollie\Gambio\Services\Business
 */
class PaymentMethodService extends BaseService
{
    protected static $instance;

    /**
     * @var array
     */
    private $savedConfigs;

    /**
     * PaymentMethodService constructor.
     */
    protected function __construct()
    {
        $repository = new GambioConfigRepository();
        $this->savedConfigs = $repository->getMollieConfiguration();

        parent::__construct();

    }

    /**
     * @param string $profileId
     *
     * @return \Mollie\BusinessLogic\PaymentMethod\Model\PaymentMethodConfig[]
     */
    public function getPaymentMethodConfigurationsMap($profileId)
    {
        $methodConfigs = [];
        $ids = $this->getSavedIds();
        foreach ($ids as $id) {
            if ($paymentMethodConfig = $this->extractLocalConfiguration($id)) {
                $methodConfigs[$paymentMethodConfig->getOriginalAPIConfig()->getId()] = $paymentMethodConfig;
            }
        }

        return $methodConfigs;
    }

    /**
     * Extracts local configuration for given method id
     *
     * @param string $id
     *
     * @return PaymentMethodConfig
     */
    public function extractLocalConfiguration($id)
    {
        $paymentMethodConfig = new PaymentMethodConfig();

        $prefix = 'MODULE_PAYMENT_' . strtoupper($id);
        $originalConfigKey = $prefix . '_ORIGINAL_CONFIG';
        $jsonConfig = json_decode($this->_getConfigValue($originalConfigKey), true);
        if (empty($jsonConfig)) {
            return null;
        }

        $originalConfig = PaymentMethod::fromArray($jsonConfig);
        $paymentMethodConfig->setOriginalAPIConfig($originalConfig);

        $lang = strtoupper($_SESSION['language_code']);
        $nameKey = $prefix . '_CHECKOUT_NAME_' . $lang;
        $descKey = $prefix . '_CHECKOUT_DESCRIPTION_' . $lang;

        $paymentMethodConfig->setId($id);
        $paymentMethodConfig->setApiMethod(@constant($prefix . '_API_METHOD'));
        $paymentMethodConfig->setName(@constant($nameKey));
        $paymentMethodConfig->setDescription(@constant($descKey));
        $paymentMethodConfig->setSurcharge(@constant($prefix . '_SURCHARGE'));
        $paymentMethodConfig->setImage(@constant($prefix . '_LOGO'));

        return $paymentMethodConfig;
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    private function _getConfigValue($key)
    {
        foreach ($this->savedConfigs as $config) {
            if ($config['configuration_key'] === $key) {
                return $config['configuration_value'];
            }
        }

        return null;
    }

    /**
     * @param array $mollieConfigs
     *
     * @return array
     */
    private function getSavedIds()
    {
        $ids = [];
        foreach ($this->savedConfigs as $config) {
            $idExploded = explode('_', $config['configuration_key']);
            $id = 'mollie_' . strtolower($idExploded[3]);
            if (!in_array($id, $ids, true)) {
                $ids[] = $id;
            }
        }

        return $ids;
    }
}
