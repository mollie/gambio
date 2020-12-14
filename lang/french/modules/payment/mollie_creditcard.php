<?php

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE', 'Credit card');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION', "Vous allez être redirigé vers le site web de la passerelle de paiement pour effectuer votre achat après l'étape de révision de la commande.");

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE', 'Activé le moyen de paiement');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC', 'Voulez-vous accepter Credit card comme paiement ?');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE', 'Nom du checkout');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC', 'Veuillez définir le nom à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE', 'Description du checkout');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC', 'Veuillez définir un texte descriptif à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE', 'Autoriser les paiements vers certains pays');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC', "Veuillez sélectionner les pays où le moyen de paiement sera disponible. Si aucun n'est sélectionné, le paiement sera disponible pour tous les pays activés.");

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE', 'Supplément');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC', 'Veuillez entrer le coût additionnel pour un paiement dans la devise par défaut. Si le champ est vide, auncun coût additionnel de paiement ne sera facturé au client.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE', "Méthode d'API");
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC', "<b>API de paiement</b><br>Utilisez la plateforme d'API de paiement pour les transactions.<br><br><b>API de commande</b><br>Utilisez la nouvelle plateforme d'API de commande et obtenez plus d'informations sur les commandes.");

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC', 'Veuillez charger le logo à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE', "Organiser l'ordre d'affichage du checkout");
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC', "Le plus bas est affiché en premier sur l'écran du checkout.");

define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE', 'Enable Mollie components on checkout');
define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC', 'When Mollie components are integrated inside the checkout process, the end-customer does not need to enter cardholder information after redirect to the Mollie payment page.');