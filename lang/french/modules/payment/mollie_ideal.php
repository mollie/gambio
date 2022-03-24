<?php

define('MODULE_PAYMENT_MOLLIE_IDEAL_TEXT_TITLE', 'iDEAL');
define('MODULE_PAYMENT_MOLLIE_IDEAL_TEXT_DESCRIPTION', "Vous allez être redirigé vers le site web de la passerelle de paiement pour effectuer votre achat après l'étape de révision de la commande.");

define('MODULE_PAYMENT_MOLLIE_IDEAL_STATUS_TITLE', 'Activé le moyen de paiement');
define('MODULE_PAYMENT_MOLLIE_IDEAL_STATUS_DESC', 'Voulez-vous accepter iDEAL comme paiement ?');

define('MODULE_PAYMENT_MOLLIE_IDEAL_CHECKOUT_NAME_TITLE', 'Nom du checkout');
define('MODULE_PAYMENT_MOLLIE_IDEAL_CHECKOUT_NAME_DESC', 'Veuillez définir le nom à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_CHECKOUT_DESCRIPTION_TITLE', 'Description du checkout');
define('MODULE_PAYMENT_MOLLIE_IDEAL_CHECKOUT_DESCRIPTION_DESC', 'Veuillez définir un texte descriptif à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_ALLOWED_ZONES_TITLE', 'Autoriser les paiements vers certains pays');
define('MODULE_PAYMENT_MOLLIE_IDEAL_ALLOWED_ZONES_DESC', "Veuillez sélectionner les pays où le moyen de paiement sera disponible. Si aucun n'est sélectionné, le paiement sera disponible pour tous les pays activés.");

define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_TITLE', 'Supplément');
define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_DESC', 'Veuillez entrer le coût additionnel pour un paiement dans la devise par défaut. Si le champ est vide, auncun coût additionnel de paiement ne sera facturé au client.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_API_METHOD_TITLE', "Méthode d'API");
define('MODULE_PAYMENT_MOLLIE_IDEAL_API_METHOD_DESC', "<b>Payment API</b><br>Utilisez la plateforme Payment API pour les transactions. <a href='https://docs.mollie.com/payments/overview' target='_blank'>Reaad more</a>..<br><br><b>Order API</b><br>Utilisez la nouvelle plateforme Order API et obtenez plus d'informations sur les commandes. <a href='https://docs.mollie.com/orders/why-use-orders' target='_blank'>Read more</a>.");

define('MODULE_PAYMENT_MOLLIE_IDEAL_LOGO_TITLE', 'Logo');
define('MODULE_PAYMENT_MOLLIE_IDEAL_LOGO_DESC', 'Veuillez charger le logo à utiliser au checkout.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_SORT_ORDER_TITLE', "Organiser l'ordre d'affichage du checkout");
define('MODULE_PAYMENT_MOLLIE_IDEAL_SORT_ORDER_DESC', "Le plus bas est affiché en premier sur l'écran du checkout.");

define('MODULE_PAYMENT_MOLLIE_IDEAL_ISSUER_LIST_TITLE', "Style de la liste d'émetteurs");
define('MODULE_PAYMENT_MOLLIE_IDEAL_ISSUER_LIST_DESC', 'Choose the style in which issuer list will be displayed on checkout.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_ORDER_EXPIRES_TITLE', '<span class="mollie_order_expires_title">Jours d\'expiration</span>');
define('MODULE_PAYMENT_MOLLIE_IDEAL_ORDER_EXPIRES_DESC', '<span class="mollie_order_expires_desc">Combien de jours avant l\'expiration des commandes pour cette méthode? Laissez vide pour utiliser l\'expiration par défaut (28 jours)</span>');

define('MODULE_PAYMENT_MOLLIE_IDEAL_TRANSACTION_DESCRIPTION_TITLE', '<span class="mollie_transaction_description_title">Description de la transaction</span>');
define('MODULE_PAYMENT_MOLLIE_IDEAL_TRANSACTION_DESCRIPTION_DESC', '<span class="mollie_transaction_description_desc">La description à utiliser pour la transaction de paiement. Ces variables sont disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} et {cartNumber}.</span>');

define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_TYPE_TITLE', 'Majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_TYPE_DESC', 'Veuillez sélectionner un type de majoration.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_FIXED_AMOUNT_TITLE', 'Montant fixe pour majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_FIXED_AMOUNT_DESC', 'Coût supplémentaire à facturer au client pour les opérations de paiement défini comme un montant fixe dans la devise du magasin par défaut.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_PERCENTAGE_TITLE', 'Pourcentage de majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_PERCENTAGE_DESC', 'Coût supplémentaire à facturer au client pour les opérations de paiement défini comme un pourcentage du sous-total du panier.');

define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_LIMIT_TITLE', 'Limite de majoration de paiement');
define('MODULE_PAYMENT_MOLLIE_IDEAL_SURCHARGE_LIMIT_DESC', 'Montant maximum de la majoration de paiement qui doit être facturée au client (dans la devise du magasin par défaut).');

