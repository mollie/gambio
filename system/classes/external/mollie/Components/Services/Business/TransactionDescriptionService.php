<?php

namespace Mollie\Gambio\Services\Business;

use Mollie\BusinessLogic\PaymentMethod\PaymentTransactionDescriptionService;

/**
 * Class TransactionDescriptionService
 *
 * @package Mollie\Gambio\Services\Business
 */
class TransactionDescriptionService extends PaymentTransactionDescriptionService
{

    /**
     * @inheritDoc
     */
    protected function getDescription($methodIdentifier)
    {
        $currentLang = strtoupper($_SESSION['language_code']);
        $methodIdentifier = strtoupper($methodIdentifier);
        $transactionDescriptionKey = "MODULE_PAYMENT_{$methodIdentifier}_TRANSACTION_DESCRIPTION_{$currentLang}";

        return @constant($transactionDescriptionKey);
    }
}
