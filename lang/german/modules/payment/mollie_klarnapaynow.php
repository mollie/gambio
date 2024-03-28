<?php

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TEXT_TITLE', 'Pay now.');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_STATUS_TITLE', 'Zahlungsmethode aktivieren');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_STATUS_DESC', 'Möchten Sie Zahlungen via Pay now akzeptieren?');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_NAME_TITLE', 'Checkout-Name');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der im Checkout angezeigt werden soll.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die im Checkout angezeigt werden soll.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SURCHARGE_TITLE', 'Aufschlag');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_API_METHOD_TITLE', 'API-Methode');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_API_METHOD_DESC', '<b>Payment API</b><br>Verwenden Sie für Transaktionen die Payment API Plattform. <a href="https://docs.mollie.com/payments/overview" target="_blank">Mehr</a>.<br><br><b>Order API</b><br>Verwenden Sie die neue Order API Platform, um mehr Einblicke in die Bestellungen zu erhalten. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Mehr</a>.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das im Checkout angezeigt werden soll.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige im Checkout');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SORT_ORDER_DESC', 'Der niedrigste Wert wird im Checkout zuerst angezeigt');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ORDER_EXPIRES_TITLE', 'Tage bis zum Ablauf');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ORDER_EXPIRES_DESC', 'Wie viele Tage, bevor Bestellungen für diese Methode abgelaufen sind? Leer lassen, um den Standardablauf zu verwenden (28 Tage)<br><br>Bitte beachten Sie: Es ist nicht möglich, ein Ablaufdatum von mehr als 28 Tagen in der Zukunft zu verwenden, es sei denn, zwischen dem Händler und Klarna wurde ein anderes Maximum vereinbart.');

defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TRANSACTION_DESCRIPTION_TITLE', 'Transaktion Beschreibung');
defined('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TRANSACTION_DESCRIPTION_DESC', 'Die Beschreibung, die für den Zahlungsvorgang verwendet werden soll. Diese Variablen sind verfügbar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} und {cartNumber}.');
