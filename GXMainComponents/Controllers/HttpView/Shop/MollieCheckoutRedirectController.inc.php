<?php

use Mollie\Gambio\MollieRedirect\MollieRedirectProvider;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieCheckoutRedirectController
 */
class MollieCheckoutRedirectController extends HttpViewController
{
    /**
     * Redirects to checkout success or payment selection, depends on the order status
     *
     * @return RedirectHttpControllerResponse
     */
    public function actionDefault()
    {
        $decoded = $this->_decodeParams();
        $orderId = $decoded['order_id'];

        $redirectProvider = new MollieRedirectProvider();

        return MainFactory::create('RedirectHttpControllerResponse', $redirectProvider->getRedirectUrl($orderId));
    }

    /**
     * @return array
     */
    private function _decodeParams()
    {
        $query = [];
        foreach ($_GET as $key => $value) {
            $realKey = str_replace('amp;', '', $key);
            $query[$realKey] = $value;
        }

        return $query;
    }
}