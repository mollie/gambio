<?php

use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;

class MolliePaymentLinkController extends AdminHttpViewController
{
    /**
     * @var $text \LanguageTextManager
     */
    protected $text;

    /**
     * @return AdminLayoutHttpControllerResponse
     */
    public function actionDefault()
    {
        $template = PathProvider::getAdminTemplate('payment_link.html', 'OrderDashboard/Popups');
        $title    = new NonEmptyStringType('Mollie Configuration');

        return MainFactory::create(
            'AdminLayoutHttpControllerResponse',
            $title,
            $template,
            $this->_getTemplateData()
        );
    }

    /**
     * @return KeyValueCollection
     */
    protected function _getTemplateData()
    {
        $orderId = $this->_getQueryParameter('orders_id');
        $customerId = $this->getSourceOrder($orderId)->getCustomerId();
        $query = [
            'order_id' => $orderId,
            'token' => md5($orderId . $customerId),
        ];

        $link    = UrlProvider::generateShopUrl('shop.php', 'MolliePaymentLinkRedirect', $query);
        $data    = [
            'css_admin'          => UrlProvider::getPluginCssUrl(''),
            'mollie_payment_url' => $link,
        ];

        return MainFactory::create('KeyValueCollection', $data);
    }

    /**
     * @param int $orderId
     *
     * @return OrderInterface
     */
    private function getSourceOrder($orderId)
    {
        /** @var OrderReadServiceInterface $orderReadService */
        $orderReadService = StaticGXCoreLoader::getService('OrderRead');
        /** @var OrderInterface $sourceOrder */
        $sourceOrder = $orderReadService->getOrderById(new IdType($orderId));

        return $sourceOrder;
    }
}
