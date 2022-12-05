# Mollie module for Gambio

## Supported GX versions
This branch contains mollie module which is eligible for Gambio versions 3.0.x - 3.4.x. 

If you have Gambio from 4.1.x to 4.4.x versions, please checkout on `4.1-4.x` branch of this Github repository.
https://github.com/mollie/gambio/tree/4.1-4.x

If you have Gambio 3.5.x - 4.0.x versions, please checkout on `3.5-4.0` branch of this Github repository.
https://github.com/mollie/gambio/tree/3.5-4.0
***

## About Mollie Payments ##
With Mollie, you can accept payments and donations online and expand your customer base internationally with support for all major payment methods through a single integration. No need to spend weeks on paperwork or security compliance procedures. No more lost conversions because you don’t support a shopper’s favourite payment method or because they don’t feel safe. We made our products and API expansive, intuitive, and safe for merchants, customers and developers alike. 

Mollie requires no minimum costs, no fixed contracts, no hidden costs. At Mollie you only pay for successful transactions. More about this pricing model can be found [here](https://www.mollie.com/en/pricing/). You can create an account [here](https://www.mollie.com/dashboard/signup). The Mollie Gambio plugin quickly integrates all major payment methods ready-made into your Gambio webshop.

# Install using FTP
```
This branch contains mollie module which is eligible for Gambio versions 3.0.x - 3.4.x. 

If you have Gambio from 4.1.x to 4.4.x versions, please checkout on `4.1-4.x` branch of this Github repository.

If you have Gambio 3.5.x - 4.0.x versions, please checkout on `3.5-4.0` branch of this Github repository.
```

To install the Mollie plugin for the **Gambio 3.0.x - 3.4.x.** system, you will need to install some FTP client (Filezilla, Free FTP, Cyberduck, WinSCP...)

Step-by-step to install the Gambio module:
 1. Download the latest `0.x.x` version of the module (the '.zip' file) via the [Releases page](https://github.com/mollie/gambio/releases) which is compatible with Gambio 3.0.x - 3.4.x.
 2. Copy the all content of the `gambio-0.x.x` directory from the extracted files to the root of your Gambio store on your webserver using your FTP client.
 3. Go to `Toolbox` » `Cache` on the Gambio admin page
 4. Clear the module, output, and text cache
 5. Go to `Modules` » `Modules-Center` on the Gambio admin page
 6. From the module list, select `Mollie` and click on the `Install` button
---

# Wiki

Read more about the integration configuration on [our Wiki](https://github.com/mollie/gambio/wiki).

# Release notes

*0.1.13*
- Fixed to not access undefined constants and check if payment method is not null for surcharge calculate.

*0.1.12*
- Added single-click payments.
- Added surcharge rules.

*0.1.11*
- Added support for the Klarna Pay Now payment method.

*0.1.10*
- Optimization: Updated the application top extender to be extendable by other modules.

*0.1.9*
- New feature: Added order expiry days configuration.
- New feature: Added a transaction description on payment methods.
- New feature: Added a notification when the current version is outdated.
- New feature: Added a notification when the shop is in offline mode.
- Optimization: Enabled payment methods are displayed as soon as the API token is verified.

*0.1.8*
- Optimization: Set the transparent background color for the mollie components.
- Optimization: By default, none of the issuers are selected. If the issuer is not selected on the payment checkout form submit, the customer will not be able to proceed with the checkout, and an error message will be displayed.
- Removed ING Home'Pay payment method from the plugin.

*0.1.7*
- Optimization: Restock product quantity, recalculate delivery status and reset article status when order is canceled during the checkout due to failed payment.

*0.1.6*
- Bugfix: Fix issues with mollie components when it is only payment method.

*0.1.5*
- Bugfix: Use first available language for status name fallback instead of English.

*0.1.4*
- Bugfix: Fix issuer class not found.

*0.1.3*
- New feature: Implemented integration with Mollie Components.
- New feature: Added iDeal, Giftcard, and KBC/CBC issuer selection in the checkout.
- Bugfix: Fixed links and icons URL within context path.

*0.1.2*
- Removed thousand separator when sending amount to Mollie API.

*0.1.1* 
- Translations for NL, DE, and FR are added.

*0.1.0*
- The initial release of Mollie integration with Gambio.
