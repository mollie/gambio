<?php

use Mollie\Gambio\Utility\CustomFieldsProvider;

require_once DIR_FS_CATALOG . '/GXModules/Mollie/Mollie/mollie_config_fields.php';

/**
 * Class Mollie_ConfigurationBoxContentView
 */
class Mollie_ConfigurationBoxContentView extends Mollie_ConfigurationBoxContentView_parent
{
    /**
     * @var CustomFieldsProvider
     */
    private $customFieldsProvider;

    /**
     * LEGACY
     * Sets a content array like in the box class
     *
     * @param array $oldSchoolContents
     */
    public function setOldSchoolContents(array $oldSchoolContents)
    {
        if(isset($_GET['set'], $_GET['module']) && $_GET['set'] === 'payment' && $this->_isMolliePayment()) {
            $this->customFieldsProvider = new CustomFieldsProvider($_GET['module']);
            if (!isset($_GET['action'])) {
                $this->_appendCustomOverview($oldSchoolContents);
            } elseif ($_GET['action'] === 'edit') {
                $this->_appendCustomFields($oldSchoolContents);
            }
        }


        parent::setOldSchoolContents($oldSchoolContents);
    }

    /**
     * @return bool
     */
    private function _isMolliePayment()
    {
        return strpos($_GET['module'], 'mollie') !== false;
    }

    /**
     * Appends custom fields info to payment method overview page
     *
     * @param array $oldSchoolContents
     *
     * @throws Exception
     */
    private function _appendCustomOverview(&$oldSchoolContents)
    {
        if (!empty($oldSchoolContents[3]['text'])) {
            $oldSchoolContents[3]['text'] = $this->customFieldsProvider->renderCustomOverviewFields() . $oldSchoolContents['3']['text'];
        }
    }

    /**
     * Renders custom fields on payment method edit
     *
     * @param array $oldSchoolContents
     *
     * @throws Exception
     */
    private function _appendCustomFields(&$oldSchoolContents)
    {
        if (!empty($oldSchoolContents[0]['text'])) {
            $oldSchoolContents[0]['text'] = $this->customFieldsProvider->renderAllCustomFields() . $oldSchoolContents['0']['text'];
        }
    }
}