<?php

define('MODULE_PAYMENT_MOLLIE_KBC_TEXT_TITLE', 'KBC/CBC Payment Button');
define('MODULE_PAYMENT_MOLLIE_KBC_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

define('MODULE_PAYMENT_MOLLIE_KBC_STATUS_TITLE', 'Zahlungsmethode aktivieren');
define('MODULE_PAYMENT_MOLLIE_KBC_STATUS_DESC', 'Möchten Sie Zahlungen via KBC/CBC Payment Button akzeptieren?');

define('MODULE_PAYMENT_MOLLIE_KBC_CHECKOUT_NAME_TITLE', 'Checkout-Name');
define('MODULE_PAYMENT_MOLLIE_KBC_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der im Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_KBC_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
define('MODULE_PAYMENT_MOLLIE_KBC_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die im Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_KBC_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
define('MODULE_PAYMENT_MOLLIE_KBC_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

define('MODULE_PAYMENT_MOLLIE_KBC_SURCHARGE_TITLE', 'Aufschlag');
define('MODULE_PAYMENT_MOLLIE_KBC_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

define('MODULE_PAYMENT_MOLLIE_KBC_API_METHOD_TITLE', 'API-Methode');
define('MODULE_PAYMENT_MOLLIE_KBC_API_METHOD_DESC', '<b>Zahlungs-API</b><br>Verwenden Sie für Transaktionen die Zahlungs-API-Plattform.<br><br><b>Zahlungs-API</b><br>Verwenden Sie die neue Order API Platform, um mehr Einblicke in die Bestellungen zu erhalten.  <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

define('MODULE_PAYMENT_MOLLIE_KBC_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_KBC_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das im Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_KBC_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige im Checkout');
define('MODULE_PAYMENT_MOLLIE_KBC_SORT_ORDER_DESC', 'Der niedrigste Wert wird im Checkout zuerst angezeigt');

define('MODULE_PAYMENT_MOLLIE_KBC_ISSUER_LIST_TITLE', 'Issuer list style');
define('MODULE_PAYMENT_MOLLIE_KBC_ISSUER_LIST_DESC', 'Choose the style in which issuer list will be displayed on checkout.');

define('MODULE_PAYMENT_MOLLIE_KBC_ORDER_EXPIRES_TITLE', 'Tage bis zum Ablauf');
define('MODULE_PAYMENT_MOLLIE_KBC_ORDER_EXPIRES_DESC', 'Wie viele Tage, bevor Bestellungen für diese Methode abgelaufen sind? Leer lassen, um den Standardablauf zu verwenden (28 Tage)');

define('MODULE_PAYMENT_MOLLIE_KBC_TRANSACTION_DESCRIPTION_TITLE', 'Transaktion Beschreibung');
define('MODULE_PAYMENT_MOLLIE_KBC_TRANSACTION_DESCRIPTION_DESC', 'Die Beschreibung, die für den Zahlungsvorgang verwendet werden soll. Diese Variablen sind verfügbar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} und {cartNumber}.');