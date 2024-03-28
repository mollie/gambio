<?php

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TEXT_TITLE', 'Pay later');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TEXT_DESCRIPTION', 'You will be redirected to payment gateway website to complete your purchase after the order review step.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_STATUS_TITLE', 'Enable payment method');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_STATUS_DESC', 'Do you want to accept Pay later as payments?');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_NAME_TITLE', 'Checkout name');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_NAME_DESC', 'Please define name that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_DESCRIPTION_TITLE', 'Checkout description');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_DESCRIPTION_DESC', 'Please define description text that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ALLOWED_ZONES_TITLE', 'Allow payment to specific countries');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ALLOWED_ZONES_DESC', 'Please select countries where payment method will be available. If none is selected, payment will be available for all activated countries.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SURCHARGE_TITLE', 'Surcharge');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SURCHARGE_DESC', 'Please enter the extra costs for a payment in default currency. If field is empty, no additional payment costs will be charged to customers.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_API_METHOD_TITLE', 'API method');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_API_METHOD_DESC', '<b>Payment API</b><br>Use the Payment API Platform for the transactions. <a href="https://docs.mollie.com/payments/overview" target="_blank">Read more</a>.<br><br><b>Order API</b><br>Use the new Order API Platform and get additional insights in the orders. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_LOGO_DESC', 'Please upload logo that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SORT_ORDER_TITLE', 'Sort order of display in checkout');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SORT_ORDER_DESC', 'Lowest is displayed first in checkout screen.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ORDER_EXPIRES_TITLE', 'Days To Expire');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ORDER_EXPIRES_DESC', 'How many days before orders for this method becomes expired? Leave empty to use default expiration (28 days)<br><br>Please note: It is not possible to use an expiry date more than 28 days in the future, unless another maximum is agreed between the merchant and Klarna.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TRANSACTION_DESCRIPTION_TITLE', 'Transaction description');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TRANSACTION_DESCRIPTION_DESC', 'The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.');
