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
        $this->issuersProvider = new MollieIssuersProvider($currentMethod, $issuerListType, $this->code);
    }

    /**
     * @inheritDoc
     * @return string[][]
     */
    public function _configuration()
    {
        $config = parent::_configuration();

        return $this->issuersProvider->extendConfiguration($config);
    }

    /**
     * @return string
     */
    public function process_button()
    {
        $this->issuersProvider->setSelectedIssuer();

        return parent::process_button();
    }

    /**
     * @inheritDoc
     * @return array|bool
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     */
    public function selection()
    {
        $selection = parent::selection();
        if (!$selection) {
            return false;
        }

        return $this->issuersProvider->extendCheckoutSelection($selection);
    }
}
