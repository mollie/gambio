<?php

use Mollie\Gambio\APIProcessor\Exceptions\FileUploadException;
use Mollie\Gambio\Utility\UrlProvider;
use Mollie\Infrastructure\Logger\Logger;

require_once DIR_FS_DOCUMENT_ROOT . '/system/classes/external/mollie/autoload.php';

/**
 * Class MollieFileUploadController
 */
class MollieFileUploadController extends AdminHttpViewController
{
    /**
     * @return JsonHttpControllerResponse
     * @throws Exception
     */
    public function actionDefault()
    {
        try {
            $imageSrc = $this->upload();
            $data = [
                'image_src' => $imageSrc,
                'is_uploaded'   => true,
            ];
        } catch (Exception $exception) {
            Logger::logError(
                "An error occurred during file upload: {$exception->getMessage()}",
                'Integration'
            );
            $data['is_uploaded'] = false;
        }

        return MainFactory::create('JsonHttpControllerResponse', $data);
    }

    /**
     * @return string
     * @throws FileUploadException
     */
    protected function upload()
    {
        $fileName = basename($_FILES['uploadFile']['name']);
        $targetFile = DIR_FS_CATALOG_IMAGES . basename($_FILES['uploadFile']['name']);

        if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $targetFile)) {
            throw new FileUploadException("Fail to upload $targetFile");
        }

        return UrlProvider::generateShopUrl("images/$fileName");
    }
}
