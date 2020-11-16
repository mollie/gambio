<?php

use Mollie\Gambio\PaymentLink\PaymentLinkProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\Logger\Logger;

include_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/autoload.php';

/**
 * Class MolliePaymentLinkRedirectController
 */
class MolliePaymentLinkRedirectController extends HttpViewController
{
    /**
     * @return RedirectHttpControllerResponse
     */
    public function actionDefault()
    {
        $orderId = $this->_getQueryParameter('order_id');
        $token   = $this->_getQueryParameter('token');
        try {
            if (!$this->_isTokenValid($orderId, $token)) {
                $redirectUrl = UrlProvider::generateShopUrl('login.php');
            } else {
                $paymentLinkProvider = new PaymentLinkProvider();
                $link = $paymentLinkProvider->createPaymentAndGetCheckoutLink($orderId);

                $redirectUrl = $link->getHref();
            }
        } catch (\Exception $exception) {
            $redirectUrl = UrlProvider::generateShopUrl('account_history_info.php', '', ['order_id' => $orderId]);
            Logger::logError(
                'Admin payment link failed',
                'Integration',
                [
                    'ExceptionMessage' => $exception->getMessage(),
                    'ExceptionTrace' => $exception->getTraceAsString(),
                ]
            );

        }

        return MainFactory::create('RedirectHttpControllerResponse', $redirectUrl);
    }

    /**
     * @param string $orderId
     * @param string $token
     *
     * @return bool
     */
    private function _isTokenValid($orderId, $token)
    {
        $customerId = $_SESSION['customer_id'];

        return md5($orderId . $customerId) === $token;
    }
}
