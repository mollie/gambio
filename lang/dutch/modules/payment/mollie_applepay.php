<?php

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_TITLE', 'Apple Pay');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_DESCRIPTION', 'Nadat je de bestelling hebt gecontroleerd, word je doorgestuurd naar de website van de betalingsprovider om je aankoop af te ronden.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_TITLE', 'Betaalmethode inschakelen');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_DESC', 'Wil je Apple Pay accepteren als betalingen?');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_TITLE', 'Naam checkout');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_DESC', 'Geef een naam op die wordt gebruikt bij het afrekenen.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_TITLE', 'Omschrijving checkout');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_DESC', 'Geef een beschrijving op die zal worden gebruikt bij het afrekenen.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_TITLE', 'Sta betalingen naar specifieke landen toe');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_DESC', 'Selecteer landen waar de betalingsmethode beschikbaar zal zijn. Als je niets selecteerd, is deze betaling beschikbaar voor alle geactiveerde landen.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TITLE', 'Toeslag');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_DESC', 'Voer de extra kosten in voor een betaling in de standaardvaluta. Als het veld leeg is, worden er geen extra betalingskosten aan klanten in rekening gebracht..');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_TITLE', 'API-methode');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_DESC', '<b>Payment API</b><br>Gebruik het Payment API Platform voor de transacties. <a href="https://docs.mollie.com/payments/overview" target="_blank">Lees meer</a>.<br><br><b>Order API</b><br>Gebruik het nieuwe Payment API Platform voor de transacties. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Lees meer</a>.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_DESC', 'Upload een logo dat zal worden gebruikt bij het afrekenen.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_TITLE', 'Sorteer de weergavevolgorde bij de checkout');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_DESC', 'De laagste wordt als eerste weergegeven in het checkout-scherm.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Dagen tot verstrijken</span>');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">Hoeveel dagen voordat bestellingen voor deze methode verlopen? Laat leeg om de standaard vervaldatum te gebruiken (28 dagen)</span>');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Transactiebeschrijving</span>');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">De beschrijving die moet worden gebruikt voor de betalingstransactie. Deze variabelen zijn beschikbaar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} en {cartNumber}.</span>');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_TITLE', 'Betalingstoeslag');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_DESC', 'Selecteer het type toeslag.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_TITLE', 'Betalingstoeslag vast bedrag');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een vast bedrag in standaard winkelvaluta.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_TITLE', 'Betalingstoeslag percentage');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een percentage van het subtotaal van de winkelwagen.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_TITLE', 'Betalingstoeslag limiet');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_DESC', 'Maximumbedrag van de betalingstoeslag die aan de klant moet worden doorberekend (in standaard winkelvaluta).');
