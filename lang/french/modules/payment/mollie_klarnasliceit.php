<?php

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TEXT_TITLE', 'Slice it');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TEXT_DESCRIPTION', "Vous allez être redirigé vers le site web de la passerelle de paiement pour effectuer votre achat après l'étape de révision de la commande.");

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_STATUS_TITLE', 'Activé le moyen de paiement');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_STATUS_DESC', 'Voulez-vous accepter Slice it comme paiement ?');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_NAME_TITLE', 'Nom du checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_NAME_DESC', 'Veuillez définir le nom à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_DESCRIPTION_TITLE', 'Description du checkout');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_CHECKOUT_DESCRIPTION_DESC', 'Veuillez définir un texte descriptif à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ALLOWED_ZONES_TITLE', 'Autoriser les paiements vers certains pays');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ALLOWED_ZONES_DESC', "Veuillez sélectionner les pays où le moyen de paiement sera disponible. Si aucun n'est sélectionné, le paiement sera disponible pour tous les pays activés.");

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SURCHARGE_TITLE', 'Supplément');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SURCHARGE_DESC', 'Veuillez entrer le coût additionnel pour un paiement dans la devise par défaut. Si le champ est vide, auncun coût additionnel de paiement ne sera facturé au client.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_API_METHOD_TITLE', "Méthode d'API");
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_API_METHOD_DESC', "<b>Payment API</b><br>Utilisez la plateforme Payment API pour les transactions. <a href='https://docs.mollie.com/payments/overview' target='_blank'>Reaad more</a>..<br><br><b>Order API</b><br>Utilisez la nouvelle plateforme Order API et obtenez plus d'informations sur les commandes. <a href='https://docs.mollie.com/orders/why-use-orders' target='_blank'>Read more</a>.");

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_LOGO_DESC', 'Veuillez charger le logo à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SORT_ORDER_TITLE', "Organiser l'ordre d'affichage du checkout");
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_SORT_ORDER_DESC', "Le plus bas est affiché en premier sur l'écran du checkout.");

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Jours d\'expiration</span>');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">Combien de jours avant l\'expiration des commandes pour cette méthode? Laissez vide pour utiliser l\'expiration par défaut (28 jours). <br><br>Remarque: il n\'est pas possible d\'utiliser une date d\'expiration de plus de 28 jours dans le futur, à moins qu\'un autre maximum ne soit convenu entre le commerçant et Klarna.</span>');

define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Description de la transaction</span>');
define('MODULE_PAYMENT_MOLLIE_KLARNASLICEIT_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">La description à utiliser pour la transaction de paiement. Ces variables sont disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} et {cartNumber}.</span>');

