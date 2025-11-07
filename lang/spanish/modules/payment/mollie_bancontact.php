<?php

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_TITLE', 'Bancontact');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TEXT_DESCRIPTION', 'Serás redirigido al sitio web de la pasarela de pago para completar tu compra después del paso de revisión del pedido.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_TITLE', 'Activar método de pago');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_STATUS_DESC', '¿Deseas aceptar pagos mediante Bancontact?');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_TITLE', 'Nombre en el pago');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_NAME_DESC', 'Por favor, define el nombre que se usará en el proceso de pago.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_TITLE', 'Descripción en el pago');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_CHECKOUT_DESCRIPTION_DESC', 'Por favor, define el texto descriptivo que se usará en el proceso de pago.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_TITLE', 'Permitir pago en países específicos');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ALLOWED_ZONES_DESC', 'Selecciona los países en los que este método de pago estará disponible. Si no se selecciona ninguno, estará disponible para todos los países activados.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TITLE', 'Recargo');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_DESC', 'Introduce los costes adicionales para un pago en la moneda predeterminada. Si el campo está vacío, no se aplicarán cargos adicionales.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_TITLE', 'Método API');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_API_METHOD_DESC', '<b>API de pagos</b><br>Usa la plataforma Payment API para las transacciones. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leer más</a>.<br><br><b>API de pedidos</b><br>Usa la nueva plataforma Order API y obtén información adicional sobre los pedidos. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leer más</a>.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_TITLE', 'Logotipo');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_LOGO_DESC', 'Por favor, sube el logotipo que se utilizará en el proceso de pago.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_TITLE', 'Orden de visualización en el pago');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SORT_ORDER_DESC', 'El número más bajo se muestra primero en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_TITLE', 'Días hasta el vencimiento');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_ORDER_EXPIRES_DESC', '¿Cuántos días deben pasar antes de que los pedidos con este método caduquen? Déjalo vacío para usar el valor predeterminado (28 días).');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_TITLE', 'Descripción de la transacción');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_TRANSACTION_DESCRIPTION_DESC', 'Descripción que se utilizará para la transacción de pago. Variables disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, y {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_TITLE', 'Tipo de recargo');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_TYPE_DESC', 'Selecciona un tipo de recargo.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_TITLE', 'Recargo de importe fijo');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_FIXED_AMOUNT_DESC', 'Coste adicional que se cobrará al cliente como un importe fijo en la moneda predeterminada de la tienda.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_TITLE', 'Recargo porcentual');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_PERCENTAGE_DESC', 'Coste adicional que se cobrará al cliente como un porcentaje del subtotal del carrito.');

defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_TITLE', 'Límite de recargo');
defined('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_BANCONTACT_SURCHARGE_LIMIT_DESC', 'Importe máximo del recargo que debe cobrarse al cliente (en la moneda predeterminada de la tienda).');