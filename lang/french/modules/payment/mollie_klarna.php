<?php

defined('MODULE_PAYMENT_MOLLIE_KLARNA_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_TEXT_TITLE', 'Klarna');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_TEXT_DESCRIPTION', "Vous allez être redirigé vers le site web de la passerelle de paiement pour effectuer votre achat après l'étape de révision de la commande.");

defined('MODULE_PAYMENT_MOLLIE_KLARNA_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_STATUS_TITLE', 'Activé le moyen de paiement');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_STATUS_DESC', 'Voulez-vous accepter Klarna comme paiement ?');

defined('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_NAME_TITLE', 'Nom du checkout');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_NAME_DESC', 'Veuillez définir le nom à utiliser au checkout.');

defined('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_DESCRIPTION_TITLE', 'Description du checkout');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_CHECKOUT_DESCRIPTION_DESC', 'Veuillez définir un texte descriptif à utiliser au checkout.');

defined('MODULE_PAYMENT_MOLLIE_KLARNA_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_ALLOWED_ZONES_TITLE', 'Autoriser les paiements vers certains pays');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_ALLOWED_ZONES_DESC', "Veuillez sélectionner les pays où le moyen de paiement sera disponible. Si aucun n'est sélectionné, le paiement sera disponible pour tous les pays activés.");

defined('MODULE_PAYMENT_MOLLIE_KLARNA_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_API_METHOD_TITLE', "Méthode d'API");
defined('MODULE_PAYMENT_MOLLIE_KLARNA_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_API_METHOD_DESC', "<b>Payment API</b><br>Utilisez la plateforme Payment API pour les transactions. <a href='https://docs.mollie.com/payments/overview' target='_blank'>Reaad more</a>..<br><br><b>Order API</b><br>Utilisez la nouvelle plateforme Order API et obtenez plus d'informations sur les commandes. <a href='https://docs.mollie.com/orders/why-use-orders' target='_blank'>Read more</a>.");

defined('MODULE_PAYMENT_MOLLIE_KLARNA_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_LOGO_DESC', 'Veuillez charger le logo à utiliser au checkout.');

defined('MODULE_PAYMENT_MOLLIE_KLARNA_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_SORT_ORDER_TITLE', "Organiser l'ordre d'affichage du checkout");
defined('MODULE_PAYMENT_MOLLIE_KLARNA_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_SORT_ORDER_DESC', "Le plus bas est affiché en premier sur l'écran du checkout.");

defined('MODULE_PAYMENT_MOLLIE_KLARNA_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_TRANSACTION_DESCRIPTION_TITLE', 'Description de la transaction');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_TRANSACTION_DESCRIPTION_DESC', 'La description à utiliser pour la transaction de paiement. Ces variables sont disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} et {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_KLARNA_CAPTURE_OPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_CAPTURE_OPTION_TITLE', 'Paiement capture');
defined('MODULE_PAYMENT_MOLLIE_KLARNA_CAPTURE_OPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_KLARNA_CAPTURE_OPTION_DESC', '<b>Sélectionnez un type de capture.<br>');