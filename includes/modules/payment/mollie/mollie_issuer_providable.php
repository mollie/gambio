<?php

use Mollie\Gambio\Utility\MollieIssuersProvider;

require_once __DIR__ . '/mollie.php';

/**
 * Class mollie_issuer_providable
 */
abstract class mollie_issuer_providable extends mollie
{
    /**
     * @var MollieIssuersProvider
     */
    protected $issuersProvider;


    /**
     * mollie_issuer_providable constructor.
     *
     * @throws \Mollie\BusinessLogic\Http\Exceptions\UnprocessableEntityRequestException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpAuthenticationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpCommunicationException
     * @throws \Mollie\Infrastructure\Http\Exceptions\HttpRequestException
     */
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