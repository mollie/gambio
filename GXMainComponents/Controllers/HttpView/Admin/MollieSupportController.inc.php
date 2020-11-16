<?php

use Mollie\Gambio\Debug\DebugService;
use Mollie\Gambio\Utility\MollieModuleChecker;
use Mollie\Infrastructure\ORM\Exceptions\RepositoryNotRegisteredException;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieAuthController
 */
class MollieSupportController extends AdminHttpViewController
{

    /**
     * @var DebugService
     */
    private $debugService;

    /**
     * Returns config information and all existing references
     *
     * @return HttpControllerResponseInterface
     * @throws RepositoryNotRegisteredException
     */
    public function actionDefault()
    {
        if (!MollieModuleChecker::isInstalled()) {
            return MainFactory::create('JsonHttpControllerResponse', []);
        }

        return MainFactory::create('JsonHttpControllerResponse', $this->_getDebugService()->getDebugInfo());
    }

    /**
     * Set debug mode from given payload
     *
     * @return HttpControllerResponseInterface
     */
    public function actionSetDebugMode()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $this->_getDebugService()->updateConfig($input);

        return MainFactory::create('JsonHttpControllerResponse', ['success' => true]);
    }

    /**
     * @return DebugService
     */
    private function _getDebugService()
    {
        if ($this->debugService === null) {
            $this->debugService = new DebugService();
        }

        return $this->debugService;
    }
}
