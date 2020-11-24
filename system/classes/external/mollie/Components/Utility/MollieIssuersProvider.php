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
     * MollieIssuersProvider constructor.
     *
     * @param PaymentMethod $paymentMethod
     * @param string $issuerListType
     */
    public function __construct($paymentMethod, $issuerListType)
    {
        $this->paymentMethod = $paymentMethod;
        $this->issuerListType = $issuerListType;
    }

    /**
     * Check whether issuer list should be displayed
     *
     * @return bool
     */
    public function displayIssuers()
    {
        return $this->issuerListType && $this->issuerListType !== 'none';
    }

    /**
     * Render issuer list
     *
     * @return string
     * @throws \Exception
     */
    public function renderIssuerList()
    {
        $template = PathProvider::getAdminTemplatePath('mollie_issuer_list.html', 'Components');

        return mollie_render_template(
            $template,
            [
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
