<?php

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE', 'Credit card');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION', 'Nadat je de bestelling hebt gecontroleerd, word je doorgestuurd naar de website van de betalingsprovider om je aankoop af te ronden.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE', 'Betaalmethode inschakelen');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC', 'Wil je Credit card accepteren als betalingen?');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE', 'Naam checkout');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC', 'Geef een naam op die wordt gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE', 'Omschrijving checkout');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC', 'Geef een beschrijving op die zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE', 'Sta betalingen naar specifieke landen toe');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC', 'Selecteer landen waar de betalingsmethode beschikbaar zal zijn. Als je niets selecteerd, is deze betaling beschikbaar voor alle geactiveerde landen.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE', 'Toeslag');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC', 'Voer de extra kosten in voor een betaling in de standaardvaluta. Als het veld leeg is, worden er geen extra betalingskosten aan klanten in rekening gebracht..');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE', 'API-methode');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC', '<b>Payment API</b><br>Gebruik het Payment API Platform voor de transacties. <a href="https://docs.mollie.com/payments/overview" target="_blank">Lees meer</a>.<br><br><b>Order API</b><br>Gebruik het nieuwe Payment API Platform voor de transacties. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Lees meer</a>.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC', 'Upload een logo dat zal worden gebruikt bij het afrekenen.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE', 'Sorteer de weergavevolgorde bij de checkout');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC', 'De laagste wordt als eerste weergegeven in het checkout-scherm.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE', 'Gebruik Mollie Components');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC', 'Read more about <a href="https://www.mollie.com/en/news/post/better-checkout-flows-with-mollie-components" target="_blank">Mollie Components</a> and how it improves your conversion');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Dagen tot verstrijken</span>');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">Hoeveel dagen voordat bestellingen voor deze methode verlopen? Laat leeg om de standaard vervaldatum te gebruiken (28 dagen)</span>');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Transactiebeschrijving</span>');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">De beschrijving die moet worden gebruikt voor de betalingstransactie. Deze variabelen zijn beschikbaar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} en {cartNumber}.</span>');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE', 'Gebruik betalen met één klik');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC', 'Lees meer over <a href="https://help.mollie.com/hc/en-us/articles/115000671249-What-are-single-click-payments-and-how-does-it-work" target="_blank">betalen met één klik</a> en hoe het uw conversie verbetert.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE', 'Toestemmingstekst betalen met één klik');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC', 'Bepaal een label voor de toestemming voor betalen met één klik.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE', 'Beschrijving betalen met één klik');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC', 'Bepaal de tekst die wordt weergegeven wanneer de klant betalen met één klik selecteert.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE', 'Betalingstoeslag');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC', 'Selecteer het type toeslag.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE', 'Betalingstoeslag vast bedrag');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een vast bedrag in standaard winkelvaluta.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE', 'Betalingstoeslag percentage');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC', 'Extra kosten die aan de klant worden doorberekend voor betalingstransacties bepaald als een percentage van het subtotaal van de winkelwagen.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE', 'Betalingstoeslag limiet');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC', 'Maximumbedrag van de betalingstoeslag die aan de klant moet worden doorberekend (in standaard winkelvaluta).');

