<?php

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TEXT_TITLE', 'Betaal nu.');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TEXT_DESCRIPTION', 'Nadat je de bestelling hebt gecontroleerd, word je doorgestuurd naar de website van de betalingsprovider om je aankoop af te ronden.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_STATUS_TITLE', 'Betaalmethode inschakelen');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_STATUS_DESC', 'Wil je Betaal nu accepteren als betalingen?');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_NAME_TITLE', 'Naam checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_NAME_DESC', 'Geef een naam op die wordt gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_DESCRIPTION_TITLE', 'Omschrijving checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_CHECKOUT_DESCRIPTION_DESC', 'Geef een beschrijving op die zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ALLOWED_ZONES_TITLE', 'Sta betalingen naar specifieke landen toe');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ALLOWED_ZONES_DESC', 'Selecteer landen waar de betalingsmethode beschikbaar zal zijn. Als je niets selecteerd, is deze betaling beschikbaar voor alle geactiveerde landen.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SURCHARGE_TITLE', 'Toeslag');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SURCHARGE_DESC', 'Voer de extra kosten in voor een betaling in de standaardvaluta. Als het veld leeg is, worden er geen extra betalingskosten aan klanten in rekening gebracht..');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_API_METHOD_TITLE', 'API-methode');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_API_METHOD_DESC', '<b>Payment API</b><br>Gebruik het Payment API Platform voor de transacties. <a href="https://docs.mollie.com/payments/overview" target="_blank">Lees meer</a>.<br><br><b>Order API</b><br>Gebruik het nieuwe Payment API Platform voor de transacties. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Lees meer</a>.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_LOGO_DESC', 'Upload een logo dat zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SORT_ORDER_TITLE', 'Sorteer de weergavevolgorde bij de checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_SORT_ORDER_DESC', 'De laagste wordt als eerste weergegeven in het checkout-scherm.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ORDER_EXPIRES_TITLE', 'Dagen tot verstrijken');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_ORDER_EXPIRES_DESC', 'Hoeveel dagen voordat bestellingen voor deze methode verlopen? Laat leeg om de standaard vervaldatum te gebruiken (28 dagen)<br><br>Let op: het is niet mogelijk om een ​​vervaldatum meer dan 28 dagen in de toekomst te gebruiken, tenzij een ander maximum is overeengekomen tussen de handelaar en Klarna.');

define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TRANSACTION_DESCRIPTION_TITLE', 'Transactiebeschrijving');
define('MODULE_PAYMENT_MOLLIE_KLARNAPAYNOW_TRANSACTION_DESCRIPTION_DESC', 'De beschrijving die moet worden gebruikt voor de betalingstransactie. Deze variabelen zijn beschikbaar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} en {cartNumber}.');