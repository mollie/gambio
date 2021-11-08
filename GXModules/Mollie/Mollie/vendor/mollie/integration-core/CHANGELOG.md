# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/).

## [v1.3.3](https://github.com/mollie/orocore/tree/v1.3.3) - 2021-11-08
- Added support for the Klarna Pay Now payment method.

## [v1.3.2](https://github.com/mollie/orocore/tree/v1.3.2) - 2021-10-07
- Fixed amount conversion to smallest unit.

## [v1.3.1](https://github.com/mollie/orocore/tree/v1.3.1) - 2021-10-05
- Added support for currencies without minor units.

## [v1.3.0](https://github.com/mollie/orocore/tree/v1.3.0) - 2021-09-13
**BREAKING CHANGES**
- Added OAuth type authorization.
- Added sort order to payment methods.
- Changed `Payment` DTO. Renamed method parameter to methods. 
  Also, all corresponding getters and setters are renamed to getMethods and 
  setMethods.
- Changed `Order` DTO. Renamed method parameter to methods.
  Also, all corresponding getters and setters are renamed to getMethods and
  setMethods.

## [v1.2.0](https://github.com/mollie/orocore/compare/v1.2.0) - 2021-03-18
 **BREAKING** Added `Configuration::getExtensionVersionCheckUrl` and 
 `Configuration::getExtensionDownloadUrl`
 - Added `VersionCheckService` for checking the latest plugin version. 
 - Added `VersionCheckProxy` is used for this service
 - Added `MaintenanceModeService` for checking whether the shop system is 
 in maintenance mode 
 - Added `PaymentTransactionDescriptionService` for formatting the description 
 of the created payment
 - Added `PaymentMethodService::getEnabledPaymentMethodsWithTempAPIKey` and
 `PaymentMethodService::getEnabledMethodsWithTempProfileId` for fetching the
 enabled methods with the temporary api key and token. 
 - Extended `PaymentMethodConfig` entity with fields: 
   `daysToExpire`, `transactionDescription`, `voucherCategory` and `productAttribute`
 - Changed `OrderService` and `PaymentService` create method, to 
 set initial status to null
 - Added `useMollieComponents` and `issuerListStyle` to the `PaymentMethodConfig`
 entity
 - Added `cardToken` property to the `Order` and `Payment` DTOs
 - Added `issuers` property to the `PaymentMethod` DTOs
 - Modify `Proxy::getAllPaymentMethods` to use `incloude=issuers` in the query string

## [v1.1.2](https://github.com/mollie/orocore/tree/v1.1.2) - 2020-11-18
 - Remove leading zeros from the phone numbers
 
## [v1.1.1](https://github.com/mollie/orocore/tree/v1.1.1) - 2020-11-12
 - Added address phone sanitization for order create/update requests.
 All common delimiters like spaces, `/`, and `-` are removed from phone input and
 code ensures that `+` sign is always at the beginning of the phone number.

## [v1.1.0](https://github.com/mollie/orocore/tree/v1.1.0) - 2020-11-05
**BREAKING CHANGES**
 - Added `AutorizationService` interface with `ApiKeyAuthService` and 
 `OrgTokenAuthService` which implement `AutorizationService` interface.
 Every integration needs to register an instance of specific integration service 
 (ApiKey or OrgToken)
 - Authorization controller
 - `ShipmentService` is added
 - `OrderService::shipOrder` is moved to `ShipmentService`  
 - Added `Proxy::getCurrentProfile` method
- Added handling of the currency's smallest unit by generating an abstract class with mappings between currencies and
 amount minor units using a console command.

## [v1.0.2](https://github.com/mollie/orocore/tree/v1.0.2) - 2020-03-20
- Remove version from composer.json file

## [v1.0.1](https://github.com/mollie/orocore/tree/v1.0.1) - 2020-03-20
- Surcharge is enabled for all payment method configurations
- Added ability for creating Mollie order/payment with multiple payment methods

## [v1.0.0](https://github.com/mollie/orocore/tree/v1.0.0) - 2020-02-18
- First release of CORE