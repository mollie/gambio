<?php

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_TITLE', 'Apple Pay');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_DESCRIPTION', 'Verrai reindirizzato al sito del gateway di pagamento per completare il tuo acquisto dopo la fase di revisione dell\'ordine.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_TITLE', 'Abilita metodo di pagamento');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_DESC', 'Vuoi accettare Apple Pay come metodo di pagamento?');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_TITLE', 'Nome al checkout');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_DESC', 'Definisci il nome che sarà utilizzato al checkout.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_TITLE', 'Descrizione al checkout');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_DESC', 'Definisci il testo descrittivo che sarà utilizzato al checkout.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_TITLE', 'Permetti il pagamento solo in specifici paesi');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_DESC', 'Seleziona i paesi in cui il metodo di pagamento sarà disponibile. Se nessuno è selezionato, il pagamento sarà disponibile per tutti i paesi attivati.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TITLE', 'Supplemento');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_DESC', 'Inserisci i costi extra per un pagamento nella valuta predefinita. Se il campo è vuoto, non verranno addebitati costi aggiuntivi.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_TITLE', 'Metodo API');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_DESC', '<b>Payment API</b><br>Utilizza la piattaforma Payment API per le transazioni. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leggi di più</a>.<br><br><b>Order API</b><br>Usa la nuova piattaforma Order API per ottenere maggiori informazioni sugli ordini. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leggi di più</a>.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_DESC', 'Carica il logo che sarà utilizzato al checkout.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_TITLE', 'Ordine di visualizzazione al checkout');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_DESC', 'Il numero più basso viene visualizzato per primo nella schermata di checkout.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_TITLE', 'Giorni prima della scadenza');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_DESC', 'Quanti giorni prima che gli ordini con questo metodo scadano? Lascia vuoto per usare la scadenza predefinita (28 giorni)');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_TITLE', 'Descrizione della transazione');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_DESC', 'Descrizione da usare per la transazione di pagamento. Variabili disponibili: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, e {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_TITLE', 'Tipo di supplemento di pagamento');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_DESC', 'Seleziona il tipo di supplemento.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_TITLE', 'Importo fisso del supplemento');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_DESC', 'Costo extra fisso addebitato al cliente per le transazioni di pagamento nella valuta predefinita.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_TITLE', 'Percentuale del supplemento di pagamento');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_DESC', 'Costo extra addebitato al cliente come percentuale del subtotale del carrello.');

defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_TITLE', 'Limite del supplemento di pagamento');
defined('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_DESC', 'Importo massimo del supplemento che può essere addebitato al cliente (nella valuta predefinita).');
