<?php

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TEXT_TITLE', 'Slice it');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TEXT_DESCRIPTION', 'Nadat je de bestelling hebt gecontroleerd, word je doorgestuurd naar de website van de betalingsprovider om je aankoop af te ronden.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_STATUS_TITLE', 'Betaalmethode inschakelen');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_STATUS_DESC', 'Wil je Slice it accepteren als betalingen?');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_NAME_TITLE', 'Naam checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_NAME_DESC', 'Geef een naam op die wordt gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_DESCRIPTION_TITLE', 'Omschrijving checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_DESCRIPTION_DESC', 'Geef een beschrijving op die zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ALLOWED_ZONES_TITLE', 'Sta betalingen naar specifieke landen toe');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ALLOWED_ZONES_DESC', 'Selecteer landen waar de betalingsmethode beschikbaar zal zijn. Als je niets selecteerd, is deze betaling beschikbaar voor alle geactiveerde landen.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SURCHARGE_TITLE', 'Toeslag');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SURCHARGE_DESC', 'Voer de extra kosten in voor een betaling in de standaardvaluta. Als het veld leeg is, worden er geen extra betalingskosten aan klanten in rekening gebracht..');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_API_METHOD_TITLE', 'API-methode');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_API_METHOD_DESC', '<b>Payment API</b><br>Gebruik het Payment API Platform voor de transacties.<br><br><b>Order API</b><br>Gebruik het nieuwe Payment API Platform voor de transacties. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Lees meer</a>.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_LOGO_DESC', 'Upload een logo dat zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SORT_ORDER_TITLE', 'Sorteer de weergavevolgorde bij de checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SORT_ORDER_DESC', 'De laagste wordt als eerste weergegeven in het checkout-scherm.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ORDER_EXPIRES_TITLE', 'Days To Expire');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ORDER_EXPIRES_DESC', 'How many days before orders for this method becomes expired? Leave empty to use default expiration (28 days)<br><br>Please note: It is not possible to use an expiry date more than 28 days in the future, unless another maximum is agreed between the merchant and Klarna.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TRANSACTION_DESCRIPTION_TITLE', 'Transaction description');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TRANSACTION_DESCRIPTION_DESC', 'The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.');
