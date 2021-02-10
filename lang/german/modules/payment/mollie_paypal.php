<?php

define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_TITLE', 'Zahlungsmethode aktivieren');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_DESC', 'Möchten Sie PayPal als Zahlungen akzeptieren?');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_TITLE', 'Checkout-Name');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TITLE', 'Aufschlag');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_TITLE', 'API-Methode');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_DESC', '<b>Zahlungs-API</b><br>Verwenden Sie für Transaktionen die Zahlungs-API-Plattform.<br><br><b>Zahlungs-API</b><br>Verwenden Sie die neue Auftrags-API-Plattform, um mehr Einblicke in die Bestellungen zu erhalten. v<a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige beim Checkout');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_DESC', 'Der niedrigste Wert wird beim Checkout zuerst angezeigt');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_TITLE', 'Days To Expire');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_DESC', 'How many days before orders for this method becomes expired? Leave empty to use default expiration (28 days)');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_TITLE', 'Transaction description');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_DESC', 'The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.');
