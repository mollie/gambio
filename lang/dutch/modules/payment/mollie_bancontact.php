<?php

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_TITLE', 'Bancontact');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_DESCRIPTION', 'Nadat je de bestelling hebt gecontroleerd, word je doorgestuurd naar de website van de betalingsprovider om je aankoop af te ronden.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_TITLE', 'Betaalmethode inschakelen');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_DESC', 'Wil je Bancontact accepteren als betalingen?');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_TITLE', 'Naam checkout');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_DESC', 'Geef een naam op die wordt gebruikt bij het afrekenen.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_TITLE', 'Omschrijving checkout');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_DESC', 'Geef een beschrijving op die zal worden gebruikt bij het afrekenen.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_TITLE', 'Sta betalingen naar specifieke landen toe');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_DESC', 'Selecteer landen waar de betalingsmethode beschikbaar zal zijn. Als je niets selecteerd, is deze betaling beschikbaar voor alle geactiveerde landen.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TITLE', 'Toeslag');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_DESC', 'Voer de extra kosten in voor een betaling in de standaardvaluta. Als het veld leeg is, worden er geen extra betalingskosten aan klanten in rekening gebracht..');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_TITLE', 'API-methode');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_DESC', '<b>Payment API</b><br>Gebruik het Payment API Platform voor de transacties. <a href="https://docs.mollie.com/payments/overview" target="_blank">Lees meer</a>.<br><br><b>Order API</b><br>Gebruik het nieuwe Payment API Platform voor de transacties. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Lees meer</a>.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_DESC', 'Upload een logo dat zal worden gebruikt bij het afrekenen.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_TITLE', 'Sorteer de weergavevolgorde bij de checkout');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_DESC', 'De laagste wordt als eerste weergegeven in het checkout-scherm.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_TITLE', 'Dagen tot verstrijken');
define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_DESC', 'Hoeveel dagen voordat bestellingen voor deze methode verlopen? Laat leeg om de standaard vervaldatum te gebruiken (28 dagen)');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_TITLE', 'Transactiebeschrijving');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_DESC', 'De beschrijving die moet worden gebruikt voor de betalingstransactie. Deze variabelen zijn beschikbaar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} en {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_TITLE', 'Betalingstoeslag');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_DESC', 'Selecteer het type toeslag.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_TITLE', 'Betalingstoeslag vast bedrag');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een vast bedrag in standaard winkelvaluta.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_TITLE', 'Betalingstoeslag percentage');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een percentage van het subtotaal van de winkelwagen.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_TITLE', 'Betalingstoeslag limiet');
define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_DESC', 'Maximumbedrag van de betalingstoeslag die aan de klant moet worden doorberekend (in standaard winkelvaluta).');
