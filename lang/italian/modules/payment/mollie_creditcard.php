<?php

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE', 'Carta di credito');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION', 'Verrai reindirizzato al sito del gateway di pagamento per completare l\'acquisto dopo la revisione dell\'ordine.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE', 'Abilita metodo di pagamento');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC', 'Vuoi accettare Carte di credito come metodo di pagamento?');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE', 'Nome nel checkout');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC', 'Definisci il nome che sarà usato nel checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE', 'Descrizione nel checkout');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC', 'Definisci il testo della descrizione che sarà usato nel checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE', 'Consenti pagamento in paesi specifici');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC', 'Seleziona i paesi in cui il metodo di pagamento sarà disponibile. Se nessuno è selezionato, il pagamento sarà disponibile per tutti i paesi attivati.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE', 'Supplemento');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC', 'Inserisci i costi aggiuntivi per il pagamento nella valuta predefinita. Se il campo è vuoto, non saranno addebitati costi aggiuntivi ai clienti.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE', 'Metodo API');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC', '<b>Payment API</b><br>Usa la piattaforma Payment API per le transazioni. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leggi di più</a>.<br><br><b>Order API</b><br>Usa la nuova piattaforma Order API per ottenere ulteriori informazioni sugli ordini. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leggi di più</a>.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC', 'Carica il logo che sarà usato nel checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE', 'Ordine di visualizzazione nel checkout');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC', 'Il numero più basso viene mostrato per primo nella schermata di checkout.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE', 'Usa Mollie Components');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC', 'Leggi di più su <a href="https://www.mollie.com/en/news/post/better-checkout-flows-with-mollie-components" target="_blank">Mollie Components</a> e come migliorano la tua conversione');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE', 'Giorni di scadenza');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC', 'Quanti giorni prima che gli ordini per questo metodo scadano? Lascia vuoto per usare la scadenza predefinita (28 giorni).');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE', 'Descrizione della transazione');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC', 'Descrizione da usare per la transazione di pagamento. Queste variabili sono disponibili: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, e {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE', 'Usa Single Click Payment');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC', 'Leggi di più su <a href="https://help.mollie.com/hc/en-us/articles/115000671249-What-are-single-click-payments-and-how-does-it-work" target="_blank">Single Click Payments</a> e come migliorano la tua conversione.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE', 'Testo approvazione Single Click Payment');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC', 'Definisci un’etichetta per l\'approvazione Single Click.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE', 'Descrizione Single Click Payment');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC', 'Definisci il testo che sarà mostrato quando il cliente seleziona il pagamento Single Click.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE', 'Supplemento di pagamento');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC', 'Seleziona un tipo di supplemento.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE', 'Importo fisso supplementare');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC', 'Costo extra addebitato al cliente per le transazioni di pagamento definito come importo fisso nella valuta predefinita.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE', 'Percentuale supplementare');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC', 'Costo extra addebitato al cliente per le transazioni di pagamento definito come percentuale del subtotale del carrello.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE', 'Limite supplemento');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC', 'Importo massimo del supplemento di pagamento che deve essere addebitato al cliente (nella valuta predefinita).');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME', 'Carta di credito');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_IT') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_IT', 'Carta di credito');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION', 'Paga in modo sicuro con la tua carta di credito');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_IT') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_IT', 'Paga in modo sicuro con la tua carta di credito');
