<?php

define('MODULE_PAYMENT_MOLLIE_SOFORT_TEXT_TITLE', 'SOFORT Banking');
define('MODULE_PAYMENT_MOLLIE_SOFORT_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_STATUS_TITLE', 'Zahlungsmethode aktivieren');
define('MODULE_PAYMENT_MOLLIE_SOFORT_STATUS_DESC', 'Möchten Sie SOFORT Banking als Zahlungen akzeptieren?');

define('MODULE_PAYMENT_MOLLIE_SOFORT_CHECKOUT_NAME_TITLE', 'Checkout-Name');
define('MODULE_PAYMENT_MOLLIE_SOFORT_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
define('MODULE_PAYMENT_MOLLIE_SOFORT_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
define('MODULE_PAYMENT_MOLLIE_SOFORT_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_SURCHARGE_TITLE', 'Aufschlag');
define('MODULE_PAYMENT_MOLLIE_SOFORT_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_API_METHOD_TITLE', 'API-Methode');
define('MODULE_PAYMENT_MOLLIE_SOFORT_API_METHOD_DESC', '<b>Zahlungs-API</b><br>Verwenden Sie für Transaktionen die Zahlungs-API-Plattform.<br><br><b>Zahlungs-API</b><br>Verwenden Sie die neue Auftrags-API-Plattform, um mehr Einblicke in die Bestellungen zu erhalten. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_SOFORT_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_SOFORT_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige beim Checkout');
define('MODULE_PAYMENT_MOLLIE_SOFORT_SORT_ORDER_DESC', 'Der niedrigste Wert wird beim Checkout zuerst angezeigt');

define('MODULE_PAYMENT_MOLLIE_SOFORT_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Tage bis zum Ablauf</span>');
define('MODULE_PAYMENT_MOLLIE_SOFORT_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">Wie viele Tage, bevor Bestellungen für diese Methode abgelaufen sind? Leer lassen, um den Standardablauf zu verwenden (28 Tage)</span>');

define('MODULE_PAYMENT_MOLLIE_SOFORT_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Transaktion Beschreibung</span>');
define('MODULE_PAYMENT_MOLLIE_SOFORT_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">Die Beschreibung, die für den Zahlungsvorgang verwendet werden soll. Diese Variablen sind verfügbar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} und {cartNumber}.</span>');

