<?php

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_TITLE', 'Apple Pay');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_DESCRIPTION', 'Nadat je de bestelling hebt gecontroleerd, word je doorgestuurd naar de website van de betalingsprovider om je aankoop af te ronden.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_TITLE', 'Betaalmethode inschakelen');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_DESC', 'Wil je Apple Pay accepteren als betalingen?');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_TITLE', 'Naam checkout');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_DESC', 'Geef een naam op die wordt gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_TITLE', 'Omschrijving checkout');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_DESC', 'Geef een beschrijving op die zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_TITLE', 'Sta betalingen naar specifieke landen toe');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_DESC', 'Selecteer landen waar de betalingsmethode beschikbaar zal zijn. Als je niets selecteerd, is deze betaling beschikbaar voor alle geactiveerde landen.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TITLE', 'Toeslag');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_DESC', 'Voer de extra kosten in voor een betaling in de standaardvaluta. Als het veld leeg is, worden er geen extra betalingskosten aan klanten in rekening gebracht..');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_TITLE', 'API-methode');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_DESC', '<b>Payment API</b><br>Gebruik het Payment API Platform voor de transacties. <a href="https://docs.mollie.com/payments/overview" target="_blank">Lees meer</a>.<br><br><b>Order API</b><br>Gebruik het nieuwe Payment API Platform voor de transacties. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Lees meer</a>.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_DESC', 'Upload een logo dat zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_TITLE', 'Sorteer de weergavevolgorde bij de checkout');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_DESC', 'De laagste wordt als eerste weergegeven in het checkout-scherm.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_TITLE', 'Dagen tot verstrijken');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_DESC', 'Hoeveel dagen voordat bestellingen voor deze methode verlopen? Laat leeg om de standaard vervaldatum te gebruiken (28 dagen)');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_TITLE', 'Transactiebeschrijving');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_DESC', 'De beschrijving die moet worden gebruikt voor de betalingstransactie. Deze variabelen zijn beschikbaar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} en {cartNumber}.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_TITLE', 'Betalingstoeslag');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_DESC', 'Selecteer het type toeslag.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_TITLE', 'Betalingstoeslag vast bedrag');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een vast bedrag in standaard winkelvaluta.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_TITLE', 'Betalingstoeslag percentage');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een percentage van het subtotaal van de winkelwagen.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_TITLE', 'Betalingstoeslag limiet');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_DESC', 'Maximumbedrag van de betalingstoeslag die aan de klant moet worden doorberekend (in standaard winkelvaluta).');
