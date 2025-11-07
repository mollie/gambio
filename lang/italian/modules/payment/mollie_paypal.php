<?php

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_TITLE', 'PayPal');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_DESCRIPTION', 'Verrai reindirizzato al sito del gateway di pagamento per completare l\'acquisto dopo la revisione dell\'ordine.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_TITLE', 'Abilita metodo di pagamento');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_DESC', 'Vuoi accettare PayPal come metodo di pagamento?');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_TITLE', 'Nome nel checkout');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_DESC', 'Definisci il nome che sarà usato nel checkout.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_TITLE', 'Descrizione nel checkout');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_DESC', 'Definisci il testo della descrizione che sarà usato nel checkout.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_TITLE', 'Consenti pagamento in paesi specifici');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_DESC', 'Seleziona i paesi in cui il metodo di pagamento sarà disponibile. Se nessuno è selezionato, il pagamento sarà disponibile per tutti i paesi attivati.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TITLE', 'Supplemento');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_DESC', 'Inserisci i costi aggiuntivi per il pagamento nella valuta predefinita. Se il campo è vuoto, non saranno addebitati costi aggiuntivi ai clienti.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_TITLE', 'Metodo API');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_DESC', '<b>Payment API</b><br>Usa la piattaforma Payment API per le transazioni. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leggi di più</a>.<br><br><b>Order API</b><br>Usa la nuova piattaforma Order API per ottenere ulteriori informazioni sugli ordini. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leggi di più</a>.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_DESC', 'Carica il logo che sarà usato nel checkout.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_TITLE', 'Ordine di visualizzazione nel checkout');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_DESC', 'Il numero più basso viene mostrato per primo nella schermata di checkout.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_TITLE', 'Giorni di scadenza');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_DESC', 'Quanti giorni prima che gli ordini per questo metodo scadano? Lascia vuoto per usare la scadenza predefinita (28 giorni).');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_TITLE', 'Descrizione della transazione');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_DESC', 'Descrizione da usare per la transazione di pagamento. Queste variabili sono disponibili: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, e {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_TITLE', 'Tipo di supplemento');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_DESC', 'Seleziona un tipo di supplemento.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_TITLE', 'Importo fisso supplementare');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_DESC', 'Costo extra addebitato al cliente per le transazioni di pagamento definito come importo fisso nella valuta predefinita.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_TITLE', 'Percentuale supplementare');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_DESC', 'Costo extra addebitato al cliente per le transazioni di pagamento definito come percentuale del subtotale del carrello.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_TITLE', 'Limite supplemento');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_DESC', 'Importo massimo del supplemento di pagamento che deve essere addebitato al cliente (nella valuta predefinita).');