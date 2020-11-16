<?php

use Mollie\Gambio\Authorization\GambioAuthorizationWrapper;
use Mollie\Gambio\Entity\StatusMapping;
use Mollie\Gambio\Utility\MollieTranslator;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;
use Mollie\Infrastructure\ORM\RepositoryRegistry;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieConfigurationController
 */
class MollieConfigurationController extends AdminHttpViewController
{

    /**
     * Saves
     *
     * @return HttpControllerResponseInterface|mixed
     */
    public function actionDefault()
    {
        try {
            $this->connect();
            $statuses = $this->_getPostData('orderStatuses');
            if (!empty($statuses)) {
                $this->_saveStatuses((array)$statuses);
            }
        } catch (Exception $e) {
            $this->_handleException($e);
        }

        return MainFactory::create(
            'RedirectHttpControllerResponse',
            UrlProvider::generateAdminUrl('admin.php', 'MollieModuleCenterModule')
        );
    }

    /**
     * Stores api credentials
     */
    private function connect()
    {
        $isTest  = $this->_getPostData('MOLLIE_TEST_MODE') === '1';
        $testKey = $this->_getPostData('MOLLIE_TEST_TOKEN');
        $liveKey = $this->_getPostData('MOLLIE_LIVE_TOKEN');

        $authWrapper = new GambioAuthorizationWrapper($isTest, $liveKey, $testKey);

        $authWrapper->connect();
    }

    /**
     * @param array $statusMap
     *
     * @throws RepositoryNotRegisteredException
     */
    private function _saveStatuses(array $statusMap)
    {
        $repository = RepositoryRegistry::getRepository(StatusMapping::getClassName());
        /** @var StatusMapping $statusEntity */
        $statusEntity = $repository->selectOne();
        if (!$statusEntity) {
            $statusEntity = new StatusMapping();
            $statusEntity->setStatusMap($statusMap);
            $repository->save($statusEntity);

            return;
        }

        $statusEntity->setStatusMap($statusMap);
        $repository->update($statusEntity);
    }

    /**
     * @param Exception $e
     */
    private function _handleException(Exception $e)
    {
        $messageKey = 'mollie_connect_failure';
        $lang       = new MollieTranslator();
        $message    = $lang->translate($messageKey) . " {$e->getMessage()}";
        $GLOBALS['messageStack']->add_session($message, 'error');
    }
}
