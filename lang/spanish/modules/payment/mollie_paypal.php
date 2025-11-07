<?php

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_TITLE', 'PayPal');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TEXT_DESCRIPTION', 'Serás redirigido al sitio web de la pasarela de pago para completar tu compra después de revisar el pedido.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_TITLE', 'Habilitar método de pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_STATUS_DESC', '¿Deseas aceptar pagos con PayPal?');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_TITLE', 'Nombre en la pantalla de pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_NAME_DESC', 'Por favor, define el nombre que se utilizará en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_TITLE', 'Descripción en la pantalla de pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_CHECKOUT_DESCRIPTION_DESC', 'Por favor, define el texto de descripción que se utilizará en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_TITLE', 'Permitir pago en países específicos');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ALLOWED_ZONES_DESC', 'Por favor, selecciona los países en los que el método de pago estará disponible. Si no se selecciona ninguno, el pago estará disponible en todos los países activados.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TITLE', 'Recargo');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_DESC', 'Introduce los costes adicionales para un pago en la moneda predeterminada. Si el campo está vacío, no se aplicarán costes adicionales al cliente.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_TITLE', 'Método API');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_API_METHOD_DESC', '<b>API de Pagos</b><br>Usa la plataforma de API de pagos para las transacciones. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leer más</a>.<br><br><b>API de Pedidos</b><br>Usa la nueva plataforma API de pedidos y obtén información adicional sobre los pedidos. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leer más</a>.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_LOGO_DESC', 'Por favor, sube el logo que se usará en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_TITLE', 'Orden de visualización en la pantalla de pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SORT_ORDER_DESC', 'El valor más bajo se mostrará primero en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_TITLE', 'Días hasta la expiración');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_ORDER_EXPIRES_DESC', '¿Cuántos días antes de que los pedidos con este método expiren? Deja vacío para usar la expiración predeterminada (28 días).');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_TITLE', 'Descripción de la transacción');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_TRANSACTION_DESCRIPTION_DESC', 'Descripción que se utilizará para la transacción de pago. Estas variables están disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, y {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_TITLE', 'Tipo de recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_TYPE_DESC', 'Por favor, selecciona un tipo de recargo.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_TITLE', 'Importe fijo del recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_FIXED_AMOUNT_DESC', 'Coste adicional que se cobrará al cliente por transacciones de pago definido como un importe fijo en la moneda predeterminada de la tienda.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_TITLE', 'Porcentaje de recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_PERCENTAGE_DESC', 'Coste adicional que se cobrará al cliente por transacciones de pago definido como un porcentaje del subtotal del carrito.');

defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_TITLE', 'Límite de recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_PAYPAL_SURCHARGE_LIMIT_DESC', 'Importe máximo del recargo por pago que se cobrará al cliente (en la moneda predeterminada de la tienda).');