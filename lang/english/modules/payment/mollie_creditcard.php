<?php

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE', 'Credit card');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION', 'You will be redirected to payment gateway website to complete your purchase after the order review step.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE', 'Enable payment method');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC', 'Do you want to accept Creditcard as payments?');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE', 'Checkout name');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC', 'Please define name that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE', 'Checkout description');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC', 'Please define description text that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE', 'Allow payment to specific countries');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC', 'Please select countries where payment method will be available. If none is selected, payment will be available for all activated countries.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE', 'Surcharge');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC', 'Please enter the extra costs for a payment in default currency. If field is empty, no additional payment costs will be charged to customers.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE', 'API method');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC', '<b>Payment API</b><br>Use the Payment API Platform for the transactions. <a href="https://docs.mollie.com/payments/overview" target="_blank">Read more</a>.<br><br><b>Order API</b><br>Use the new Order API Platform and get additional insights in the orders. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC', 'Please upload logo that will be used in checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE', 'Sort order of display in checkout');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC', 'Lowest is displayed first in checkout screen.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE', 'Use Mollie Components');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC', 'Read more about <a href="https://www.mollie.com/en/news/post/better-checkout-flows-with-mollie-components" target="_blank">Mollie Components</a> and how it improves your conversion');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE', 'Days To Expire');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC', 'How many days before orders for this method becomes expired? Leave empty to use default expiration (28 days)');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE', 'Transaction description');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC', 'The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE', 'Use Single Click Payment');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC', 'Read more about <a href="https://help.mollie.com/hc/en-us/articles/115000671249-What-are-single-click-payments-and-how-does-it-work" target="_blank">Single Click Payments</a> and how it improves your conversion.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE', 'Single Click Payment Approval Text');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC', 'Please define a label for the Single Click approval.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE', 'Single Click Payment Description');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC', 'Please define text that will be displayed when the customer selects Single Click payment.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE', 'Payment surcharge');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC', 'Please select a surcharge type.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE', 'Payment surcharge fixed amount');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC', 'Extra cost to be charged to the customer for payment transactions defined as a fixed amount in default store currency.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE', 'Payment surcharge percentage');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC', 'Extra cost to be charged to the customer for payment transactions defined as a percentage of the cart subtotal.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE', 'Payment surcharge limit');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC', 'Maximum amount of payment surcharge that should be charged to the customer (in default store currency).');