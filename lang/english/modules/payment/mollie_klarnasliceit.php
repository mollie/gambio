<?php

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TEXT_TITLE', 'Slice it');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TEXT_DESCRIPTION', 'You will be redirected to payment gateway website to complete your purchase after the order review step.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_STATUS_TITLE', 'Enable payment method');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_STATUS_DESC', 'Do you want to accept Slice it as payments?');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_NAME_TITLE','Checkout name');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_NAME_DESC','Please define name that will be used in checkout.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_DESCRIPTION_TITLE', 'Checkout description');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_DESCRIPTION_DESC', 'Please define description text that will be used in checkout.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ALLOWED_ZONES_TITLE' , 'Allow payment to specific countries');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ALLOWED_ZONES_DESC' , 'Please select countries where payment method will be available. If none is selected, payment will be available for all activated countries.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SURCHARGE_TITLE' , 'Surcharge');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SURCHARGE_DESC' , 'Please enter the extra costs for a payment in default currency. If field is empty, no additional payment costs will be charged to customers.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_API_METHOD_TITLE' , 'API method');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_API_METHOD_DESC' , '<b>Payment API</b><br>Use the Payment API Platform for the transactions.<br><br><b>Order API</b><br>Use the new Order API Platform and get additional insights in the orders. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_LOGO_DESC', 'Please upload logo that will be used in checkout.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SORT_ORDER_TITLE', 'Sort order of display in checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SORT_ORDER_DESC', 'Lowest is displayed first in checkout screen.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ORDER_EXPIRES_TITLE', 'Days To Expire');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ORDER_EXPIRES_DESC', 'How many days before orders for this method becomes expired? Leave empty to use default expiration (28 days)<br><br>Please note: It is not possible to use an expiry date more than 28 days in the future, unless another maximum is agreed between the merchant and Klarna.');
