<?php

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_TITLE', 'Tarjeta de crédito');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TEXT_DESCRIPTION', 'Serás redirigido al sitio web de la pasarela de pago para completar tu compra después de revisar el pedido.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_TITLE', 'Habilitar método de pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_STATUS_DESC', '¿Deseas aceptar tarjetas de crédito como método de pago?');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_TITLE', 'Nombre en la pantalla de pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_DESC', 'Por favor, define el nombre que se usará en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_TITLE', 'Descripción en la pantalla de pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_DESC', 'Por favor, define el texto descriptivo que se mostrará en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_TITLE', 'Permitir pago en países específicos');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ALLOWED_ZONES_DESC', 'Selecciona los países donde estará disponible este método de pago. Si no seleccionas ninguno, estará disponible para todos los países activados.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TITLE', 'Recargo');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_DESC', 'Introduce los costes adicionales para un pago en la moneda predeterminada. Si el campo está vacío, no se aplicarán costes adicionales al cliente.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_TITLE', 'Método API');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_API_METHOD_DESC', '<b>API de Pagos</b><br>Usa la plataforma Payment API para las transacciones. <a href="https://docs.mollie.com/payments/overview" target="_blank">Leer más</a>.<br><br><b>API de Pedidos</b><br>Usa la nueva plataforma Order API y obtén información adicional sobre los pedidos. <a href="https://docs.mollie.com/orders/why-use-orders" target="_blank">Leer más</a>.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_TITLE', 'Logo');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_LOGO_DESC', 'Por favor, sube el logo que se mostrará en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_TITLE', 'Orden de visualización en la pantalla de pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SORT_ORDER_DESC', 'Los valores más bajos se muestran primero en la pantalla de pago.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_TITLE', 'Usar Mollie Components');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_COMPONENTS_STATUS_DESC', 'Lee más sobre <a href="https://www.mollie.com/en/news/post/better-checkout-flows-with-mollie-components" target="_blank">Mollie Components</a> y cómo mejora la conversión.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_TITLE', 'Días hasta la expiración');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_ORDER_EXPIRES_DESC', '¿Cuántos días antes de que los pedidos con este método expiren? Deja vacío para usar el valor predeterminado (28 días).');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_TITLE', 'Descripción de la transacción');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_TRANSACTION_DESCRIPTION_DESC', 'Descripción que se utilizará para la transacción. Variables disponibles: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, y {cartNumber}.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_TITLE', 'Usar pago con un solo clic');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_STATUS_DESC', 'Lee más sobre <a href="https://help.mollie.com/hc/en-us/articles/115000671249-What-are-single-click-payments-and-how-does-it-work" target="_blank">pagos con un solo clic</a> y cómo mejora tu conversión.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_TITLE', 'Texto de aprobación para pago con un solo clic');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_APPROVAL_TEXT_DESC', 'Define una etiqueta para la aprobación del pago con un solo clic.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_TITLE', 'Descripción del pago con un solo clic');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SINGLE_CLICK_DESCRIPTION_DESC', 'Define el texto que se mostrará cuando el cliente seleccione el pago con un solo clic.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_TITLE', 'Tipo de recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_TYPE_DESC', 'Por favor, selecciona un tipo de recargo.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_TITLE', 'Recargo fijo por pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_FIXED_AMOUNT_DESC', 'Coste adicional que se cobrará al cliente como un importe fijo en la moneda predeterminada de la tienda.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_TITLE', 'Porcentaje de recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_PERCENTAGE_DESC', 'Coste adicional que se cobrará al cliente como porcentaje del subtotal del carrito.');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_TITLE', 'Límite de recargo por pago');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_SURCHARGE_LIMIT_DESC', 'Importe máximo del recargo por pago que se cobrará al cliente (en la moneda predeterminada de la tienda).');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME', 'Tarjeta de crédito');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_ES') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_NAME_ES', 'Tarjeta de crédito');

defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION', 'Paga de forma segura con tu tarjeta de crédito');
defined('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_ES') ?: define('MODULE_PAYMENT_MOLLIE_CREDITCARD_CHECKOUT_DESCRIPTION_ES', 'Paga de forma segura con tu tarjeta de crédito');
