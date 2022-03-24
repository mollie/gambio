<?php

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_TITLE', 'Apple Pay');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TEXT_DESCRIPTION', "Vous allez être redirigé vers le site web de la passerelle de paiement pour effectuer votre achat après l'étape de révision de la commande.");

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_TITLE', 'Activé le moyen de paiement');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_STATUS_DESC', 'Voulez-vous accepter Apple Pay comme paiement ?');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_TITLE', 'Nom du checkout');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_NAME_DESC', 'Veuillez définir le nom à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_TITLE', 'Description du checkout');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_CHECKOUT_DESCRIPTION_DESC', 'Veuillez définir un texte descriptif à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_TITLE', 'Autoriser les paiements vers certains pays');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ALLOWED_ZONES_DESC', "Veuillez sélectionner les pays où le moyen de paiement sera disponible. Si aucun n'est sélectionné, le paiement sera disponible pour tous les pays activés.");

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TITLE', 'Supplément');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_DESC', 'Veuillez entrer le coût additionnel pour un paiement dans la devise par défaut. Si le champ est vide, auncun coût additionnel de paiement ne sera facturé au client.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_TITLE', "Méthode d'API");
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_API_METHOD_DESC', "<b>Payment API</b><br>Utilisez la plateforme Payment API pour les transactions. <a href='https://docs.mollie.com/payments/overview' target='_blank'>Reaad more</a>..<br><br><b>Order API</b><br>Utilisez la nouvelle plateforme Order API et obtenez plus d'informations sur les commandes. <a href='https://docs.mollie.com/orders/why-use-orders' target='_blank'>Read more</a>.");

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_LOGO_DESC', 'Veuillez charger le logo à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_TITLE', "Organiser l'ordre d'affichage du checkout");
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SORT_ORDER_DESC', "Le plus bas est affiché en premier sur l'écran du checkout.");

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_TITLE', "Jours d'expiration");
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_ORDER_EXPIRES_DESC', "Combien de jours avant l'expiration des commandes pour cette méthode? Laissez vide pour utiliser l'expiration par défaut (28 jours)");

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_TITLE', 'Description de la transaction');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_TRANSACTION_DESCRIPTION_DESC', 'La description à utiliser pour la transaction de paiement. Ces variables sont disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} et {cartNumber}.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_TITLE', 'Majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_TYPE_DESC', 'Veuillez sélectionner un type de majoration.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_TITLE', 'Montant fixe pour majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_FIXED_AMOUNT_DESC', 'Coût supplémentaire à facturer au client pour les opérations de paiement défini comme un montant fixe dans la devise du magasin par défaut.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_TITLE', 'Pourcentage de majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_PERCENTAGE_DESC', 'Coût supplémentaire à facturer au client pour les opérations de paiement défini comme un pourcentage du sous-total du panier.');

define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_TITLE', 'Limite de majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_APPLEPAY_SURCHARGE_LIMIT_DESC', 'Montant maximum de la majoration de paiement qui doit être facturée au client (dans la devise du magasin par défaut).');
