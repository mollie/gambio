<?php

$t_language_text_section_content_array = [
    'mollie_title'                   => 'Mollie',
    'mollie_description'             => 'Mollie-Zahlungsmodul',
    'mollie_version'                 => 'Version',
    'mollie_test_mode'               => 'Test mode',
    'mollie_live_token'              => 'Live-API-Schlüssel',
    'mollie_test_token'              => 'Test-API-Schlüssel',
    'mollie_live_token_msg'          => 'Den Live-API-Schlüssel finden Sie in Ihrem <a href="https://www.mollie.com/dashboard/developers/api-keys" target="_blank">Mollie-Profil</a>.',
    'mollie_test_token_msg'          => 'Den Test-API-Schlüssel finden Sie in Ihrem <a href="https://www.mollie.com/dashboard/developers/api-keys" target="_blank">Mollie-Profil</a>.',
    'mollie_verify'                  => 'Token bestätigen',
    'mollie_support'                 => 'Support',
    'mollie_support_link'            => 'https://help.mollie.com/hc/de',
    'mollie_status'                  => 'Status',
    'mollie_connect_success'         => '<i class="fa fa-check"></i> Verbindung zu <b>{key_type} API</b> erfolgreich.<br><br><i class="fa fa-cog"></i> Aktivierte Methoden: {enabled_methods}',
    'mollie_connect_failure'         => '<i class="fa times"></i> Ein Authentifizierungsfehler ist aufgetreten. Ungültiges Zugriffstoken Profil.',
    'mollie_keys_missing'            => '<i class="fa fa-times"></i> Bitte geben Sie mindestens einen API-Schlüssel an',
    'mollie_configuration_failure'   => '<i class="fa fa-times"></i> Ein Fehler beim Speichern der Mollie-Konfiguration: {api_message}',
    'mollie_active'                  => 'Aktiv',
    'mollie_inactive'                => 'Inaktiv',
    'mollie_configure'               => 'Konfigurieren',
    'mollie_payment_methods'         => 'Zahlungsmethoden',
    'mollie_configuration'           => 'Mollie-Konfiguration',
    'mollie_enabled'                 => 'Aktiviert',
    'mollie_disabled'                => 'Deaktiviert',
    'mollie_connected'               => 'Verbunden',
    'mollie_not_connected'           => 'Nicht verbunden',
    'mollie_notifications'           => 'Benachrichtigungen',
    'mollie_date'                    => 'Datum',
    'mollie_type'                    => 'Typ',
    'mollie_order_number'            => 'Auftragsnummer',
    'mollie_message'                 => 'Nachricht',
    'mollie_details'                 => 'Details',
    'mollie_info'                    => 'Info',
    'mollie_warning'                 => 'Warnung',
    'mollie_error'                   => 'Fehler',
    'mollie_order_statuses'          => 'Auftragsstatus',
    'mollie_created'                 => 'Erstellt',
    'mollie_authorized'              => 'Genehmigt',
    'mollie_paid'                    => 'Bezahlt',
    'mollie_refunded'                => 'Zurückerstattet',
    'mollie_none'                    => 'Keine',
    'mollie_cancel'                  => 'Storniert',
    'mollie_save_changes'            => 'Änderungen speichern',
    'mollie_dashboard_title'         => 'Mollie-Zahlungsinformationen',
    'mollie_payment_method'          => 'Zahlungsmethode',
    'mollie_checkout_type'           => 'Art des Checkouts',
    'mollie_payment_status'          => 'Zahlungsstatus',
    'mollie_order_status'            => 'Auftragsstatus',
    'mollie_paid_amount'             => 'Betrag',
    'mollie_refunded_amount'         => 'Erstatteter Betrag',
    'mollie_payment_link'            => 'Zahlungslink',
    'mollie_shipments'               => 'Shipments',

    'mollie_issuer_list_dropdown'    => 'Dropdown',
    'mollie_issuer_list_images'      => 'Liste mit Abbildungen',
    'mollie_issuer_not_selected'     => 'Aussteller nicht ausgewählt',

    'mollie_select_bank'             => 'Bank auswählen',
    'mollie_card_holder'             => 'Kartenhalter',
    'mollie_card_number'             => 'Kartenhalter',
    'mollie_expiry_date'             => 'Verfallsdatum',
    'mollie_verification_code'       => 'Verifizierungs-Schlüssel',

    'mollie_transaction_desc_label' => 'Die Beschreibung, die für den Zahlungsvorgang verwendet werden soll. Diese Variablen sind verfügbar: {orderNumber}, {storeName}, {customerFirstname}, {customerLastname}, {customerCompany} und {cartNumber}.',

    'mollie_canceled_comment' => 'Der Kunde hat die Zahlung abgebrochen.',
    'mollie_expired_comment'  => 'Die Zahlung ist bei Mollie abgelaufen.',
    'mollie_failed_comment'   => 'Die Zahlung ist fehlgeschlagen und kann mit der gewählten Zahlungsmethode nicht abgeschlossen werden.',

    'mollie.payment.integration.event.notification.order_cancel_error.title'       => 'Synchronisieren von Shop-Änderungen fehlgeschlagen',
    'mollie.payment.integration.event.notification.order_cancel_error.description' => 'Mollie-Bestellung konnte nicht storniert werden. Antwort Mollie-API {api_message}',

    'mollie.payment.integration.event.notification.order_cancel.title'       => 'Auftragsstornierungsereignis erkannt',
    'mollie.payment.integration.event.notification.order_cancel.description' => 'Die Stornierung von Bestellungen wird nicht unterstützt, daher wird diese Änderung nicht mit dem Mollie synchronisiert',

    'mollie.payment.integration.event.notification.billing_address_change_error.title'       => 'Synchronisieren von Shop-Änderungen fehlgeschlagen',
    'mollie.payment.integration.event.notification.billing_address_change_error.description' => 'Aktualisieren der Rechnungsadresse für die Mollie-Bestellung fehlgeschlagen. Antwort Mollie-API {api_message}',

    'mollie.payment.integration.event.notification.shipping_address_change_error.title'       => 'Synchronisieren von Shop-Änderungen fehlgeschlagen',
    'mollie.payment.integration.event.notification.shipping_address_change_error.description' => 'Aktualisieren der Lieferadresse für die Mollie-Bestellung fehlgeschlagen. Antwort Mollie-API {api_message}',

    'mollie.payment.integration.event.notification.order_line_changed_error.title'       => 'Synchronisieren Bestellposition fehlgeschlagen',
    'mollie.payment.integration.event.notification.order_line_changed_error.description' => 'Aktualisieren Bestellposition für zugehörige Mollie-Bestellung fehlgeschlagen. Antwort Mollie-API {api_message}',

    'mollie.payment.integration.event.notification.order_ship_error.title'       => 'Synchronisieren von Shop-Änderungen fehlgeschlagen',
    'mollie.payment.integration.event.notification.order_ship_error.description' => 'Erstellen Lieferung für zugehörige Mollie-Bestellung fehlgeschlagen. Antwort Mollie-API {api_message}',

    'mollie.payment.integration.event.notification.order_total_changed.title'       => 'Ereignis Gesamtbestellwert geändert erkannt',
    'mollie.payment.integration.event.notification.order_total_changed.description' => 'Gesamtbestellwert Ändern wird nicht unterstützt; die Änderung wird nicht mit Mollie synchronisiert',

    'mollie.payment.webhook.notification.order_line_refund_info.title'       => 'Mollie-Bestellposition geändert',
    'mollie.payment.webhook.notification.order_line_refund_info.description' => 'Bestellposition im Mollie-Portal erstattet.',

    'mollie.payment.webhook.notification.invalid_shop_order.title'       => 'Mollie-Änderung für unbekannte Bestellung',
    'mollie.payment.webhook.notification.invalid_shop_order.description' => 'Änderung von Mollie wurde erkannt, aber es wurde keine zugehörige Bestellung im System gefunden',

    'mollie.payment.webhook.notification.invalid_credentials.title'       => 'Molllie-Änderung wurde nicht synchronisiert',
    'mollie.payment.webhook.notification.invalid_credentials.description' => 'Authentication error has occurred. Invalid Organization access token.',

    'mollie.payment.webhook.notification.invalid_api_order.title'       => 'Mollie change for unknown order',
    'mollie.payment.webhook.notification.invalid_api_order.description' => 'Änderung von Mollie erkannt, aber es wurde keine entsprechende Zahlung in der Mollie-API gefunden. Antwort Mollie-API {api_message}.',

    'mollie.payment.webhook.notification.network_communication_problem.title'       => 'Molllie-Änderung wurde nicht synchronisiert',
    'mollie.payment.webhook.notification.network_communication_problem.description' => 'Änderung von Mollie erkannt, aber Netzwerkverbindung mit Mollie-API konnte nicht hergestellt werden. Technische Details: {technical_message}.',

    'mollie.payment.webhook.notification.order_pay_error.title'       => 'Molllie-Änderung wurde nicht synchronisiert',
    'mollie.payment.webhook.notification.order_pay_error.description' => 'Bestellung im Mollie-Portal bezahlt.',

    'mollie.payment.webhook.notification.order_expire_error.title'       => 'Molllie-Änderung wurde nicht synchronisiert',
    'mollie.payment.webhook.notification.order_expire_error.description' => 'Bestellung im Mollie-Portal abgelaufen.',

    'mollie.payment.webhook.notification.order_cancel_error.title'       => 'Molllie-Änderung wurde nicht synchronisiert',
    'mollie.payment.webhook.notification.order_cancel_error.description' => 'Bestellung im Mollie-Portal storniert.',

    'mollie.payment.webhook.notification.order_refund_error.title'       => 'Molllie-Änderung wurde nicht synchronisiert',
    'mollie.payment.webhook.notification.order_refund_error.description' => 'Bestellung im Mollie-Portal erstattet.',

    'mollie.payment.webhook.notification.order_line_cancel_info.title'       => 'Mollie order line changed',
    'mollie.payment.webhook.notification.order_line_cancel_info.description' => 'Bestellposition im Molli-Portal storniert.',

    'mollie_version_outdated_message' => 'Eine neue Modulversion {versionNumber} ist verfügbar. Bitte laden Sie die neueste Version herunter <a href="{downloadUrl}" target="_blank">here</a>',
    'mollie_system_offline_message'   => 'Ihre Website wird im Offline-Modus ausgeführt. Da Mollie eine Nachricht an Ihre Website sendet, wenn sich der Zahlungsstatus ändert, kann Mollie im Offline-Modus nicht auf Ihre Website zugreifen',

    'mollie_status_label'          => 'Mollie status',
    'mollie_gambio_status_label'   => 'Gambio status',
    'mollie_method_label'          => 'Method',

];