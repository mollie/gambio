<?php

$t_language_text_section_content_array = [
    'mollie_title'                   => 'Mollie',
    'mollie_description'             => 'Mollie payment module',
    'mollie_version'                 => 'Version',
    'mollie_test_mode'               => 'Test mode',
    'mollie_live_token'              => 'Live API key',
    'mollie_test_token'              => 'Test API key',
    'mollie_live_token_msg'          => 'You can find your live Api Key in your <a href="https://www.mollie.com/dashboard/developers/api-keys" target="_blank">Mollie Profile</a>.',
    'mollie_test_token_msg'          => 'You can find your test Api Key in your <a href="https://www.mollie.com/dashboard/developers/api-keys" target="_blank">Mollie Profile</a>.',
    'mollie_verify'                  => 'Verify token',
    'mollie_support'                 => 'Support',
    'mollie_support_link'            => 'https://help.mollie.com/hc/en-us',
    'mollie_status'                  => 'Status',
    'mollie_connect_success'         => 'A connection was successfully established with the Mollie API. Please save changes to proceed with payment setup.',
    'mollie_connect_failure'         => 'Authentication error has occurred. Invalid profile access token.',
    'mollie_active'                  => 'Active',
    'mollie_inactive'                => 'Inactive',
    'mollie_configure'               => 'Configure',
    'mollie_payment_methods'         => 'Payment methods',
    'mollie_configuration'           => 'Mollie configuration',
    'mollie_enabled'                 => 'Enabled',
    'mollie_disabled'                => 'Disabled',
    'mollie_connected'               => 'Connected',
    'mollie_not_connected'           => 'Not connected',
    'mollie_notifications'           => 'Notifications',
    'mollie_date'                    => 'Date',
    'mollie_type'                    => 'Type',
    'mollie_order_number'            => 'Order Number',
    'mollie_message'                 => 'Message',
    'mollie_details'                 => 'Details',
    'mollie_info'                    => 'Info',
    'mollie_warning'                 => 'Warning',
    'mollie_error'                   => 'Error',
    'mollie_order_statuses'          => 'Order statuses',
    'mollie_created'                 => 'Created',
    'mollie_authorized'              => 'Authorized',
    'mollie_paid'                    => 'Paid',
    'mollie_refunded'                => 'Refunded',
    'mollie_none'                    => 'None',
    'mollie_cancel'                  => 'Cancel',
    'mollie_save_changes'            => 'Save changes',
    'mollie_save_mapping_success'    => 'Order status mapping successfully updated',
    'mollie_save_mapping_error'      => 'Fail to save order statuses: {message}',
    'mollie_dashboard_title'         => 'Mollie Payment Information',
    'mollie_payment_method'          => 'Payment method',
    'mollie_checkout_type'           => 'Checkout type',
    'mollie_payment_status'          => 'Payment status',
    'mollie_order_status'            => 'Order status',
    'mollie_paid_amount'             => 'Amount',
    'mollie_refunded_amount'         => 'Refunded amount',
    'mollie_payment_link'            => 'Payment link',
    'mollie_shipments'               => 'Shipments',
    'mollie_refunds'                 => 'Refunds',
    'mollie_open_in_mollie'          => 'Open in Mollie',
    'mollie_payment_link_message'    => 'Is your payment still pending? Copy this payment link and send it to your customer. It will redirect them to the checkout page, where they can initiate the payment again.',
    'mollie_items'                   => 'Items',
    'mollie_amount'                  => 'Amount',
    'mollie_model'                   => 'Model',
    'mollie_products'                => 'Products',
    'mollie_ordered_qty'             => 'Ordered Qty',
    'mollie_shipped_qty'             => 'Shipped Qty',
    'mollie_shipped_at'              => 'Shipped at',
    'mollie_qty_to_ship'             => 'Qty to Ship',
    'mollie_carrier'                 => 'Carrier',
    'mollie_tracking_code'           => 'Tracking code',
    'mollie_tracking_url'            => 'Tracking URL',
    'mollie_submit_shipment'         => 'Submit shipment',
    'mollie_copy_to_clipboard'       => 'Copy to clipboard',
    'mollie_refund'                  => 'Refund',
    'mollie_refunded_qty'            => 'Refunded Qty',
    'mollie_qty_to_refund'           => 'Qty to refund',
    'mollie_payment_refund'          => 'Payment refund',
    'mollie_refund_amount'           => 'Refund amount',
    'mollie_refund_reason'           => 'Reason for refund',
    'mollie_total'                   => 'Total',
    'mollie_price'                   => 'Price',
    'mollie_refund_message'          => 'This payment was made as part of an order and it is recommended to refund individual order lines.',
    'mollie_total_refunded'          => 'Amount already refunded',
    'mollie_available_to_refund'     => 'Remaining refundable amount',
    'mollie_refund_success'          => 'Payment successfully refunded',
    'mollie_refund_error'            => 'Payment cannot be refunded. Mollie API response: ',
    'mollie_not_refundable'          => 'Total amount has been already refunded',
    'mollie_not_shippable'           => 'All items have been already shipped',
    'mollie_shipment_create_success' => 'Shipment successfully created on Mollie',
    'mollie_shipment_create_error'   => 'Failed to create shipment for related Mollie order. Mollie api response {api_message}',
    'mollie_change_logo'             => 'Change logo',
    'mollie_change_logo_error'       => 'Failed to upload logo',
    'mollie_orders_api'              => 'Orders API',
    'mollie_payments_api'            => 'Payments API',
    'mollie_unknown_error'           => 'Unknown error occurred on Mollie API',
    'mollie_checkout_desc'           => 'You will be redirected to payment gateway website to complete your purchase after the order review step.',

    'mollie_issuer_list_dropdown'    => 'Dropdown',
    'mollie_issuer_list_images'      => 'List with images',
    'mollie_issuer_not_selected'     => 'Issuer not selected!',

    'mollie_select_bank'             => 'Select bank',
    'mollie_card_holder'             => 'Card holder',
    'mollie_card_number'             => 'Card number',
    'mollie_expiry_date'             => 'Expiry date',
    'mollie_verification_code'       => 'Verification code',

    'mollie_transaction_desc_label' => 'The description to be used for payment transaction. These variables are available: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany}, and {cartNumber}.',

    'mollie_canceled_comment' => 'The customer has canceled the payment.',
    'mollie_expired_comment'  => 'The payment has expired on Mollie.',
    'mollie_failed_comment'   => 'The payment has failed and cannot be completed with selected payment method.',

    'mollie.payment.integration.event.notification.order_cancel_error.title'       => 'Shop change synchronization failed',
    'mollie.payment.integration.event.notification.order_cancel_error.description' => 'Failed to cancel Mollie order. Mollie api response {api_message}',

    'mollie.payment.integration.event.notification.order_cancel.title'       => 'Order cancel event detected',
    'mollie.payment.integration.event.notification.order_cancel.description' => 'Order cancel is not supported, so this change is not synchronized to the Mollie',

    'mollie.payment.integration.event.notification.billing_address_change_error.title'       => 'Shop change synchronization failed',
    'mollie.payment.integration.event.notification.billing_address_change_error.description' => 'Failed to update billing address on Mollie order. Mollie api response {api_message}',

    'mollie.payment.integration.event.notification.shipping_address_change_error.title'       => 'Shop change synchronization failed',
    'mollie.payment.integration.event.notification.shipping_address_change_error.description' => 'Failed to update shipping address on Mollie order. Mollie api response {api_message}',

    'mollie.payment.integration.event.notification.order_line_changed_error.title'       => 'Order line synchronization failed',
    'mollie.payment.integration.event.notification.order_line_changed_error.description' => 'Failed to update order line for related Mollie order. Mollie api response {api_message}',

    'mollie.payment.integration.event.notification.order_ship_error.title'       => 'Shop change synchronization failed',
    'mollie.payment.integration.event.notification.order_ship_error.description' => 'Failed to create shipment for related Mollie order. Mollie api response {api_message}',

    'mollie.payment.integration.event.notification.order_total_changed.title'       => 'Order total change event detected',
    'mollie.payment.integration.event.notification.order_total_changed.description' => 'Order total change is not supported, so this change is not synchronized to the Mollie',

    'mollie.payment.webhook.notification.order_line_refund_info.title'       => 'Mollie order line changed',
    'mollie.payment.webhook.notification.order_line_refund_info.description' => 'Order line is refunded in Mollie portal.',

    'mollie.payment.webhook.notification.invalid_shop_order.title'       => 'Mollie change for unknown order',
    'mollie.payment.webhook.notification.invalid_shop_order.description' => 'Change from Mollie is detected but matching order could not be found in the system.',

    'mollie.payment.webhook.notification.invalid_credentials.title'       => 'Mollie change is not synchronized',
    'mollie.payment.webhook.notification.invalid_credentials.description' => 'Authentication error has occurred. Invalid Organization access token.',

    'mollie.payment.webhook.notification.invalid_api_order.title'       => 'Mollie change for unknown order',
    'mollie.payment.webhook.notification.invalid_api_order.description' => 'Change from Mollie is detected but matching payment could not be found in the Mollie api. Mollie api response {api_message}.',

    'mollie.payment.webhook.notification.network_communication_problem.title'       => 'Mollie change is not synchronized',
    'mollie.payment.webhook.notification.network_communication_problem.description' => 'Change from Mollie is detected but network connection with Mollie API could not be established. Technical details: {technical_message}.',

    'mollie.payment.webhook.notification.order_pay_error.title'       => 'Mollie change is not synchronized',
    'mollie.payment.webhook.notification.order_pay_error.description' => 'Order is paid in Mollie portal.',

    'mollie.payment.webhook.notification.order_expire_error.title'       => 'Mollie change is not synchronized',
    'mollie.payment.webhook.notification.order_expire_error.description' => 'Order is expired in Mollie portal.',

    'mollie.payment.webhook.notification.order_cancel_error.title'       => 'Mollie change is not synchronized',
    'mollie.payment.webhook.notification.order_cancel_error.description' => 'Order is canceled in Mollie portal.',

    'mollie.payment.webhook.notification.order_refund_error.title'       => 'Mollie change is not synchronized',
    'mollie.payment.webhook.notification.order_refund_error.description' => 'Order is refunded in Mollie portal.',

    'mollie.payment.webhook.notification.order_line_cancel_info.title'       => 'Mollie order line changed',
    'mollie.payment.webhook.notification.order_line_cancel_info.description' => 'Order line is canceled in Mollie portal.',
];