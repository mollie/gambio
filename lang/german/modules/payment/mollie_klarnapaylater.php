<?php

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TEXT_TITLE', 'Pay later');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_STATUS_TITLE', 'Zahlungsmethode aktivieren');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_STATUS_DESC', 'Möchten Sie Pay later als Zahlungen akzeptieren?');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_NAME_TITLE', 'Checkout-Name');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SURCHARGE_TITLE', 'Aufschlag');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_API_METHOD_TITLE', 'API-Methode');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_API_METHOD_DESC', '<b>Zahlungs-API</b><br>Verwenden Sie für Transaktionen die Zahlungs-API-Plattform.<br><br><b>Zahlungs-API</b><br>Verwenden Sie die neue Auftrags-API-Plattform, um mehr Einblicke in die Bestellungen zu erhalten. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Read more</a>.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das beim Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige beim Checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_SORT_ORDER_DESC', 'Der niedrigste Wert wird beim Checkout zuerst angezeigt');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Days To Expire</span>');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">How many days before orders for this method becomes expired? Leave empty to use default expiration (28 days)<br><br>Please note: It is not possible to use an expiry date more than 28 days in the future, unless another maximum is agreed between the merchant and Klarna.</span>');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Transaction description</span>');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYLATER_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.</span>');
