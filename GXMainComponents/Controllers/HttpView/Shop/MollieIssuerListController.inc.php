<?php

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieIssuerListController
 */
class MollieIssuerListController extends HttpViewController
{
    /**
     * Store issuer in session upon submit payment button
     *
     * @return HttpControllerResponseInterface|mixed
     */
    public function actionDefault()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!empty($input['issuer'])) {
            $_SESSION['mollie_issuer'] = $input['issuer'];
        }

        return MainFactory::create(
            'JsonHttpControllerResponse',
            ['success' => true]
        );
    }
}
