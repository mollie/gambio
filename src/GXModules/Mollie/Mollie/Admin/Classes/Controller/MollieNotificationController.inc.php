<?php

use Mollie\BusinessLogic\Notifications\Interfaces\DefaultNotificationChannelAdapter;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Infrastructure\ServiceRegister;

require_once __DIR__ . '/../../../autoload.php';

/**
 * Class MollieNotificationController
 */
class MollieNotificationController extends AdminHttpViewController
{
    const NOTIFICATIONS_PER_PAGE = 5;

    /**
     * @return JsonHttpControllerResponse
     */
    public function actionDefault()
    {
        $page = $this->_getQueryParameter('page');

        return MainFactory::create(
            'JsonHttpControllerResponse',
            $this->_formatNotifications((int)$page)
        );
    }

    /**
     * @param int $page
     *
     * @return array
     */
    protected function _formatNotifications($page)
    {
        $formattedNotifications = [];
        $offset                 = static::NOTIFICATIONS_PER_PAGE * $page;
        /** @var DefaultNotificationChannelAdapter $service */
        $service       = ServiceRegister::getService(DefaultNotificationChannelAdapter::CLASS_NAME);
        $notifications = $service->get(static::NOTIFICATIONS_PER_PAGE, $offset);
        foreach ($notifications as $notification) {
            $date                                  = new DateTime("@{$notification->getTimestamp()}");
            $formattedNotification['id']           = $notification->getId();
            $formattedNotification['date']         = $date->format('d-m-y');
            $formattedNotification['time']         = $date->format('h:i A');
            $formattedNotification['order_number'] = $notification->getOrderNumber();
            $formattedNotification['severity']     = $notification->getSeverity();
            $message                               = $notification->getMessage();
            $desc                                  = $notification->getDescription();
            $formattedNotification['message']      = $this->_getTranslated($message->getMessageKey(), $message->getMessageParams());
            $formattedNotification['description']  = $this->_getTranslated($desc->getMessageKey(), $desc->getMessageParams());

            $formattedNotifications[] = $formattedNotification;
        }

        return $formattedNotifications;
    }

    /**
     * @param string $key
     * @param array  $params
     *
     * @return string
     */
    private function _getTranslated($key, $params)
    {
        $languageManager = new MollieTranslator();

        return $languageManager->translate($key, $this->formatParams($params));
    }

    /**
     * @param array $params
     *
     * @return array
     */
    private function formatParams(array $params)
    {
        $formatted = [];
        foreach ($params as $key => $value) {
            $formattedKey             = '{' . $key . '}';
            $formatted[$formattedKey] = $value;
        }

        return $formatted;
    }
}
