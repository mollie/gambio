<?php

use Mollie\BusinessLogic\Http\DTO\Payments\Amount;
use Mollie\BusinessLogic\Http\DTO\Payments\Capture;
use Mollie\BusinessLogic\Http\Proxy;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Gambio\Utility\PathProvider;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/../../../autoload.php';

/**
 * Class MollieCaptureController
 */
class MollieCaptureController extends AdminHttpViewController
{
    const FALLBACK_CURRENCY = 'EUR';

    /**
     * @var Proxy
     */
    private $proxy;

    /**
     * @return AdminLayoutHttpControllerResponse
     */
    public function actionDefault()
    {
        $template = PathProvider::getAdminTemplate('capture.html', 'OrderDashboard/Popups');
        $title = new NonEmptyStringType('Mollie Configuration');
        $data = MainFactory::create('KeyValueCollection', $this->_getTemplateData());

        return MainFactory::create('AdminLayoutHttpControllerResponse', $title, $template, $data);
    }

    /**
     * @return JsonHttpControllerResponse
     */
    public function actionSubmitCapture()
    {
        $messageKey = 'mollie_capture_create_success';
        $messageType = 'success';
        $apiMsg = '';
        try {
            $payload = json_decode(file_get_contents('php://input'), true);
            $transactionId = $this->_handleOrderTransaction($payload['transactionId']);

            $this->_getProxy()->createCapture($this->prepareCapture($payload), $transactionId);
        } catch (Exception $exception) {
            $messageKey = 'mollie_capture_create_error';
            $messageType = 'error';
            $apiMsg = $exception->getMessage();
        }

        $this->_pushMessage($messageKey, $apiMsg, $messageType);

        $data['success'] = true;

        return MainFactory::create('JsonHttpControllerResponse', $data);
    }

    /**
     * @param array $requestPayload
     *
     * @return Capture
     */
    private function prepareCapture($requestPayload)
    {
        $capture = new Capture();
        $captureAmount = new Amount();
        $captureAmount->setValue(number_format((float)$requestPayload['amountForCapture'], 2, '.', ''));
        $captureAmount->setCurrency(isset($_SESSION['currency']) ? $_SESSION['currency'] : self::FALLBACK_CURRENCY);
        $capture->setAmount($captureAmount);
        $capture->setDescription('Created capture for the transaction ' .
            $requestPayload['transactionId'] . ' for amount ' . $requestPayload['amountForCapture']);

        return $capture;
    }

    /**
     * @return array
     */
    private function _getTemplateData()
    {
        $transactionId = $this->_getQueryParameter('transaction_id');
        $transactionId = $this->_handleOrderTransaction($transactionId);
        $capturedAmount = $this->fetchCapturedAmount($transactionId);
        $totalPaidAmount = $this->fetchTotalPaidAmount($transactionId);
        $leftForCapture = round((float)$totalPaidAmount - $capturedAmount, 2);

        return [
            'js_admin' => UrlProvider::getPluginJavascriptUrl(''),
            'css_admin' => UrlProvider::getPluginCssUrl(''),
            'total_for_capture' => $leftForCapture,
            'captured_amount' => $capturedAmount,
            'left_for_capture' => $leftForCapture,
            'process_capture_url' => UrlProvider::generateAdminUrl(
                'admin.php',
                'MollieCapture/submitCapture',
                ['transaction_id' => $transactionId]
            )
        ];
    }

    /**
     * @param string $transactionId
     *
     * @return string
     */
    private function _handleOrderTransaction($transactionId)
    {
        if (strpos($transactionId, 'ord_') !== false) {
            try {
                $order = $this->_getProxy()->getOrder($transactionId);
                $payment = $order->getEmbedded()['payments'];
                if (count($payment) > 0) {
                    $payment = $payment[0];

                    return $payment->getId();
                }
            } catch (Exception $e) {}
        }

        return $transactionId;
    }

    /**
     * @param string $transactionId
     *
     * @return float
     */
    private function fetchCapturedAmount($transactionId)
    {
        $capturedAmount = 0;

        try {
            $captures = $this->_getProxy()->getCaptures($transactionId);
            foreach ($captures as $capture) {
                $capturedAmount += (float)$capture->getAmount()->getValueAmount();
            }
        } catch (Exception $e) {
        }

        return $capturedAmount;
    }

    /**
     * @param $transactionId
     *
     * @return float
     */
    private function fetchTotalPaidAmount($transactionId)
    {
        try {
            $mollieTransaction = $this->_getProxy()->getPayment($transactionId);

            return round((float)$mollieTransaction->getAmount()->getAmountValue(), 2);
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * @param string $messageKey
     * @param string $apiMsg
     * @param string $messageType
     */
    private function _pushMessage($messageKey, $apiMsg, $messageType)
    {
        $languageTextManager = new MollieTranslator();
        $message = $languageTextManager->translate($messageKey, ['{api_message}' => $apiMsg]);
        $GLOBALS['messageStack']->add_session($message, $messageType);
    }

    /**
     * @return Proxy
     */
    private function _getProxy()
    {
        if ($this->proxy === null) {
            $this->proxy = ServiceRegister::getService(Proxy::CLASS_NAME);
        }

        return $this->proxy;
    }
}
