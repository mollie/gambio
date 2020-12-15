<?php

namespace Mollie\Gambio\Utility;

use Mollie\BusinessLogic\Http\DTO\PaymentMethod;

/**
 * Class MollieIssuersProvider
 *
 * @package Mollie\Gambio\Utility
 */
class MollieIssuersProvider
{
    /**
     * @var PaymentMethod
     */
    private $paymentMethod;
    /**
     * @var string
     */
    private $issuerListType;
    /**
     * @var string
     */
    private $code;

    /**
     * MollieIssuersProvider constructor.
     *
     * @param PaymentMethod $paymentMethod
     * @param string $issuerListType
     * @param string $code
     */
    public function __construct($paymentMethod, $issuerListType, $code)
    {
        $this->paymentMethod = $paymentMethod;
        $this->issuerListType = $issuerListType;
        $this->code = $code;
    }

    /**
     * Extends base configuration with the issuer specific fields
     *
     * @param array $configuration
     *
     * @return mixed
     */
    public function extendConfiguration(array $configuration)
    {
        $configuration['ISSUER_LIST'] = [
            'configuration_value' => 'list',
            'set_function'        => 'mollie_issuer_list_select( ',
        ];

        return $configuration;
    }

    /**
     * Extends base selection with issuer list
     *
     * @param array $selection
     *
     * @return array
     * @throws \Exception
     */
    public function extendCheckoutSelection(array $selection)
    {
        if ($this->displayIssuers()) {
            $selection['description'] .= $this->renderIssuerList();
        }

        return $selection;
    }

    /**
     * Store selected issuer on checkout into session
     */
    public function setSelectedIssuer()
    {
        if (!empty($_POST[$this->code . '-issuer'])) {
            $_SESSION['mollie_issuer'] = $_POST[$this->code . '-issuer'];
        }
    }

    /**
     * Check whether issuer list should be displayed
     *
     * @return bool
     */
    private function displayIssuers()
    {
        return $this->issuerListType && $this->issuerListType !== 'none';
    }

    /**
     * Render issuer list
     *
     * @return string
     * @throws \Exception
     */
    private function renderIssuerList()
    {
        $template = PathProvider::getAdminTemplatePath('mollie_issuer_list.html', 'Components');

        return mollie_render_template(
            $template,
            [
                'payment_method' => $this->code,
                'issuers' => $this->_formatIssuers(),
                'list_type' => $this->issuerListType,
            ]
        );
    }

    /**
     * @return array
     */
    private function _formatIssuers()
    {
        $issuersFormatted = [];
        foreach ($this->paymentMethod->getIssuers() as $issuer) {
            $issuersFormatted[] = $issuer->toArray();
        }

        return $issuersFormatted;
    }
}
