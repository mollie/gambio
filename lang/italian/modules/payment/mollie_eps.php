<?php

defined('MODULE_PAYMENT_MOLLIE_EPS_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_TEXT_TITLE', 'eps');
defined('MODULE_PAYMENT_MOLLIE_EPS_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_EPS_TEXT_DESCRIPTION', 'Verrai reindirizzato al sito del gateway di pagamento per completare il tuo acquisto dopo la fase di revisione dell\'ordine.');

defined('MODULE_PAYMENT_MOLLIE_EPS_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_STATUS_TITLE', 'Abilita metodo di pagamento');
defined('MODULE_PAYMENT_MOLLIE_EPS_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_STATUS_DESC', 'Vuoi accettare pagamenti tramite eps?');

defined('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_NAME_TITLE', 'Nome alla cassa');
defined('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_NAME_DESC', 'Definisci il nome che sarà utilizzato durante il checkout.');

defined('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_DESCRIPTION_TITLE', 'Descrizione al checkout');
defined('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_CHECKOUT_DESCRIPTION_DESC', 'Definisci il testo della descrizione che sarà utilizzato durante il checkout.');

defined('MODULE_PAYMENT_MOLLIE_EPS_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_ALLOWED_ZONES_TITLE', 'Consenti pagamento solo in specifici paesi');
defined('MODULE_PAYMENT_MOLLIE_EPS_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_ALLOWED_ZONES_DESC', 'Seleziona i paesi in cui il metodo di pagamento sarà disponibile. Se nessuno è selezionato, il pagamento sarà disponibile in tutti i paesi attivi.');

defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_TITLE', 'Supplemento');
defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_DESC', 'Inserisci i costi aggiuntivi per il pagamento nella valuta predefinita. Se il campo è vuoto, non verranno addebitati costi aggiuntivi.');

defined('MODULE_PAYMENT_MOLLIE_EPS_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_API_METHOD_TITLE', 'Metodo API');
defined('MODULE_PAYMENT_MOLLIE_EPS_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_API_METHOD_DESC', '<b>Payment API</b><br>Usa la piattaforma Payment API per le transazioni. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leggi di più</a>.<br><br><b>Order API</b><br>Usa la nuova piattaforma Order API per ottenere ulteriori dettagli sugli ordini. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leggi di più</a>.');

defined('MODULE_PAYMENT_MOLLIE_EPS_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_EPS_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_LOGO_DESC', 'Carica il logo che sarà utilizzato durante il checkout.');

defined('MODULE_PAYMENT_MOLLIE_EPS_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SORT_ORDER_TITLE', 'Ordine di visualizzazione al checkout');
defined('MODULE_PAYMENT_MOLLIE_EPS_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SORT_ORDER_DESC', 'Il valore più basso sarà visualizzato per primo nella schermata di checkout.');

defined('MODULE_PAYMENT_MOLLIE_EPS_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_ORDER_EXPIRES_TITLE', 'Giorni di scadenza');
defined('MODULE_PAYMENT_MOLLIE_EPS_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_ORDER_EXPIRES_DESC', 'Quanti giorni prima che gli ordini con questo metodo scadano? Lascia vuoto per usare la scadenza predefinita (28 giorni).');

defined('MODULE_PAYMENT_MOLLIE_EPS_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_TRANSACTION_DESCRIPTION_TITLE', 'Descrizione della transazione');
defined('MODULE_PAYMENT_MOLLIE_EPS_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_TRANSACTION_DESCRIPTION_DESC', 'Descrizione da usare per la transazione di pagamento. Variabili disponibili: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} e {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_TYPE_TITLE', 'Tipo di supplemento');
defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_TYPE_DESC', 'Seleziona un tipo di supplemento.');

defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_FIXED_AMOUNT_TITLE', 'Importo fisso supplemento');
defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_FIXED_AMOUNT_DESC', 'Costo aggiuntivo addebitato al cliente per le transazioni di pagamento definito come importo fisso nella valuta predefinita del negozio.');

defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_PERCENTAGE_TITLE', 'Percentuale supplemento');
defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_PERCENTAGE_DESC', 'Costo aggiuntivo addebitato al cliente definito come percentuale del totale del carrello.');

defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_LIMIT_TITLE', 'Limite supplemento');
defined('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_EPS_SURCHARGE_LIMIT_DESC', 'Importo massimo del supplemento che può essere addebitato al cliente (nella valuta predefinita del negozio).');
