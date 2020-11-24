<?php

use Mollie\Gambio\Utility\MollieIssuersProvider;

require_once __DIR__ . '/mollie/mollie.php';

/**
 * Class mollie_ideal
 */
class mollie_ideal extends mollie
{
    public $title = 'iDEAL';

    /**
     * @var MollieIssuersProvider
     */
    private $issuersProvider;

    public function __construct()
    {
        parent::__construct();
        $currentMethod = $this->_getCurrentMollieMethod();
        $issuerListType = @constant($this->_formatKey('ISSUER_LIST'));
        $this->issuersProvider = new MollieIssuersProvider($currentMethod, $issuerListType);
    }

    /**
     * @inheritDoc
     * @return string[][]
     */
    public function _configuration()
    {
        $config = parent::_configuration();
        $config['ISSUER_LIST'] = [
            'configuration_value' => 'none',
            'set_function'        => 'mollie_issuer_list_select( ',
        ];

        return $config;
    }

    public function selection()
    {
        $selection = parent::selection();
        if (!$selection) {
            return false;
        }

        if ($this->issuersProvider->displayIssuers()) {
            $selection['description'] .= $this->issuersProvider->renderIssuerList();
        }

        return $selection;
    }
}