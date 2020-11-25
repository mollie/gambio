<?php


class MollieCardTokenController extends HttpViewController
{
    /**
     * Store issuer in session upon submit payment button
     *
     * @return HttpControllerResponseInterface|mixed
     */
    public function actionDefault()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!empty($input['card_token'])) {
            $_SESSION['card_token'] = $input['card_token'];
        }

        return MainFactory::create(
            'JsonHttpControllerResponse',
            ['success' => true]
        );
    }
}