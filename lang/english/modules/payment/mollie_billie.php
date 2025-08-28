<?php

defined('MODULE_PAYMENT_MOLLIE_BILLIE_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_TEXT_TITLE', 'Billie');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_TEXT_DESCRIPTION', 'You will be redirected to payment gateway website to complete your purchase after the order review step.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_STATUS_TITLE', 'Enable payment method');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_STATUS_DESC', 'Do you want to accept Billie as payments?');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_NAME_TITLE', 'Checkout name');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_NAME_DESC', 'Please define name that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_DESCRIPTION_TITLE', 'Checkout description');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_CHECKOUT_DESCRIPTION_DESC', 'Please define description text that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_ALLOWED_ZONES_TITLE', 'Allow payment to specific countries');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_ALLOWED_ZONES_DESC', 'Please select countries where payment method will be available. If none is selected, payment will be available for all activated countries.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_API_METHOD_TITLE', 'API method');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_API_METHOD_DESC', '<b>Payment API</b><br>Use the Payment API Platform for the transactions. <a href="https://docs.mollie.com/payments/overview" target="_blank">Read more</a>.<br>');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_LOGO_DESC', 'Please upload logo that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_SORT_ORDER_TITLE', 'Sort order of display in checkout');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_SORT_ORDER_DESC', 'Lowest is displayed first in checkout screen.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_TRANSACTION_DESCRIPTION_TITLE', 'Transaction description');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_TRANSACTION_DESCRIPTION_DESC', 'The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_BILLIE_CAPTURE_OPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_CAPTURE_OPTION_TITLE', 'Payment capture');
defined('MODULE_PAYMENT_MOLLIE_BILLIE_CAPTURE_OPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BILLIE_CAPTURE_OPTION_DESC', '<b>Select a capture type.<br>');