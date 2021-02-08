<?php


namespace Mollie\Gambio\Mappers;


use Mollie\BusinessLogic\Configuration;
use Mollie\BusinessLogic\Http\DTO\Amount;
use Mollie\BusinessLogic\Http\DTO\Payment;
use Mollie\Gambio\Entity\Repository\GambioProductRepository;
use Mollie\Gambio\Services\Business\ConfigurationService;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\ServiceRegister;

trait MapperUtility
{
    /**
     * @var GambioProductRepository
     */
    protected $productRepository;
    /**
     * @var ConfigurationService
     */
    protected $configService;

    /**
     * @param $orderId
     *
     * @return string
     */
    protected function _getRedirectUrl($orderId)
    {
        return UrlProvider::generateShopUrl('shop.php', 'MollieCheckoutRedirect', ['order_id' => $orderId]);
    }

    /**
     * @return string
     */
    protected function _getLanguage()
    {
        $currentLanguage = $_SESSION['language_code'];
        $countryCode     = $currentLanguage === 'en' ? 'US' : strtoupper($currentLanguage);

        return $currentLanguage . '_' . $countryCode;
    }

    /**
     * @param $paymentClass
     *
     * @return string
     */
    protected function _formatPaymentMethod($paymentClass)
    {
        if (strpos($paymentClass, 'mollie_') !== false) {
            return substr($paymentClass, strlen('mollie_'));
        }

        return $paymentClass;

    }

    /**
     * @param string $currency
     * @param string $value
     *
     * @return Amount
     */
    protected function _getAmount($currency, $value)
    {
        $amount = new Amount();

        $amount->setCurrency($currency);
        $amount->setAmountValue($value);

        return $amount;
    }

    /**
     * Adds issuer and card token params
     *
     * @param Payment $payment
     */
    protected function addSpecificParameters($payment)
    {
        if (!empty($_SESSION['mollie_issuer'])) {
            $payment->setIssuer($_SESSION['mollie_issuer']);
            unset($_SESSION['mollie_issuer']);
        }

        if (!empty($_SESSION['mollie_card_token'])) {
            $payment->setCardToken($_SESSION['mollie_card_token']);
            unset($_SESSION['mollie_card_token']);
        }
    }

    /**
     * @param string $imageName
     *
     * @return string
     */
    protected function _getProductImageUrl($imageName)
    {
        return UrlProvider::generateShopUrl("images/product_images/original_images/$imageName");
    }

    /**
     * @return GambioProductRepository
     */
    protected function _getProductRepository()
    {
        if ($this->productRepository === null) {
            $this->productRepository = new GambioProductRepository();
        }

        return $this->productRepository;
    }

    /**
     * @return ConfigurationService
     */
    protected function _getConfigService()
    {
        if ($this->configService === null) {
            $this->configService = ServiceRegister::getService(Configuration::CLASS_NAME);
        }

        return $this->configService;
    }

    /**
     * @param string $paymentClass
     *
     * @return mixed
     */
    protected function getDaysToExpireOrder($paymentClass)
    {
        $module = strtoupper($paymentClass);
        $key = "MODULE_PAYMENT_{$module}_ORDER_EXPIRES";

        return @constant($key);
    }

    protected function getDaysToExpirePayment($paymentClass)
    {
        if ($paymentClass === 'mollie_banktransfer' && defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_DUE_DATE')) {
            $daysToExpire = MODULE_PAYMENT_MOLLIE_BANKTRANSFER_DUE_DATE;

            return !empty($daysToExpire) ? $daysToExpire : null;
        }

        return null;
    }
}
