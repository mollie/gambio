<?php

define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_TITLE', 'PayPal');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_TITLE', 'Zahlungsmethode aktivieren');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_DESC', 'Möchten Sie Zahlungen via PayPal akzeptieren?');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_TITLE', 'Checkout-Name');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der im Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die im Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TITLE', 'Aufschlag');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_TITLE', 'API-Methode');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_DESC', '<b>Payment API</b><br>Verwenden Sie für Transaktionen die Payment API Plattform. <a href="https://docs.mollie.com/payments/overview" target="_blank">Mehr</a>.<br><br><b>Order API</b><br>Verwenden Sie die neue Order API Platform, um mehr Einblicke in die Bestellungen zu erhalten. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Mehr</a>.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das im Checkout angezeigt werden soll.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige im Checkout');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_DESC', 'Der niedrigste Wert wird im Checkout zuerst angezeigt');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_TITLE', 'Tage bis zum Ablauf');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_DESC', 'Wie viele Tage, bevor Bestellungen für diese Methode abgelaufen sind? Leer lassen, um den Standardablauf zu verwenden (28 Tage)');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_TITLE', 'Transaktion Beschreibung');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_DESC', 'Die Beschreibung, die für den Zahlungsvorgang verwendet werden soll. Diese Variablen sind verfügbar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} und {cartNumber}.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_TITLE', 'Zahlungszuschlag');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_DESC', 'Wählen Sie einen Zuschlagstyp aus.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_TITLE', 'Fester Zahlungszuschlag');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_DESC', 'Zusätzliche Kosten die für Zahlungsvorgänge anfallen und als fester Betrag in der Standardwährung des Shops berechnet werden.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_TITLE', 'Anteiliger Zahlungszuschlag');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_DESC', 'Zusätzliche Kosten die für Zahlungsvorgänge anfallen und als Anteil am Gesamtwert des Einkaufswagens berechnet werden.');

define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_TITLE', 'Maximaler Zahlungszuschlag');
define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_DESC', 'Maximaler Betrag eines Zahlungszuschlags der berechnet werden kann (in der Standardwährung des Shops).');
