<?php

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TEXT_TITLE', 'Bank transfer');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TEXT_DESCRIPTION', 'Nach dem Kontrollieren Ihrer Bestellung werden Sie zur Website des Zahlungsanbieters weitergeleitet, um den Einkauf abzuschließen.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_STATUS_TITLE', 'Zahlungsmethode aktivieren');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_STATUS_DESC', 'Möchten Sie Zahlungen via Bank transfer akzeptieren?');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_NAME_TITLE', 'Checkout-Name');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_NAME_DESC', 'Bitte geben Sie den Namen an, der im Checkout angezeigt werden soll.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_DESCRIPTION_TITLE', 'Checkout-Beschreibung');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_CHECKOUT_DESCRIPTION_DESC', 'Bitte geben Sie eine Beschreibung an, die im Checkout angezeigt werden soll.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ALLOWED_ZONES_TITLE', 'Zahlungen in ausgewählte Länder erlauben');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ALLOWED_ZONES_DESC', 'Wählen Sie die Länder aus, in denen die Zahlungsmethode verfügbar sein wird. Wir keine ausgewählt, so ist die Zahlung für alle aktivierten Länder verfügbar.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_TITLE', 'Aufschlag');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_DESC', 'Geben Sie die zusätzlichen Kosten für eine Zahlung in der Standardwährung ein. Bleibt dieses Feld leer, werden den Kunden keine zusätzlichen Kosten berechnet.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_API_METHOD_TITLE', 'API-Methode');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_API_METHOD_DESC', '<b>Payment API</b><br>Verwenden Sie für Transaktionen die Payment API Plattform. <a href="https://docs.mollie.com/payments/overview" target="_blank">Mehr</a>.<br><br><b>Order API</b><br>Verwenden Sie die neue Order API Platform, um mehr Einblicke in die Bestellungen zu erhalten. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Mehr</a>.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_LOGO_DESC', 'Bitte laden Sie ein Logo hoch, das im Checkout angezeigt werden soll.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SORT_ORDER_TITLE', 'Sortierreihenfolge der Anzeige im Checkout');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SORT_ORDER_DESC', 'Der niedrigste Wert wird im Checkout zuerst angezeigt');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Tage bis zum Ablauf</span>');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">Wie viele Tage, bevor Bestellungen für diese Methode abgelaufen sind? Leer lassen, um den Standardablauf zu verwenden (28 Tage)</span>');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Transaktion Beschreibung</span>');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">Die Beschreibung, die für den Zahlungsvorgang verwendet werden soll. Diese Variablen sind verfügbar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} und {cartNumber}.</span>');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_TYPE_TITLE', 'Zahlungszuschlag');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_TYPE_DESC', 'Wählen Sie einen Zuschlagstyp aus.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_FIXED_AMOUNT_TITLE', 'Fester Zahlungszuschlag');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_FIXED_AMOUNT_DESC', 'Zusätzliche Kosten die für Zahlungsvorgänge anfallen und als fester Betrag in der Standardwährung des Shops berechnet werden.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_PERCENTAGE_TITLE', 'Anteiliger Zahlungszuschlag');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_PERCENTAGE_DESC', 'Zusätzliche Kosten die für Zahlungsvorgänge anfallen und als Anteil am Gesamtwert des Einkaufswagens berechnet werden.');

defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_LIMIT_TITLE', 'Maximaler Zahlungszuschlag');
defined('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANKTRANSFER_SURCHARGE_LIMIT_DESC', 'Maximaler Betrag eines Zahlungszuschlags der berechnet werden kann (in der Standardwährung des Shops).');
