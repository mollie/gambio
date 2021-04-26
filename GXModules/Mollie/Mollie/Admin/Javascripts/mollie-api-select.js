$(document).ready(function () {
    let apiMethodChooser = $('.mollie-api-select');

    if (apiMethodChooser.length) {
        // initial fields display
        displayFieldsBasedOnMethod(apiMethodChooser.val());

        // adding change listener
        apiMethodChooser.change(function () {
            displayFieldsBasedOnMethod(($(this).val()))
        })

    }

    /**
     * Displays fields based on the selected payment method
     *
     * @param {string} apiMethod
     */
    function displayFieldsBasedOnMethod(apiMethod) {
        let wrapper = $('#configuration-box-form');
        if (wrapper.length === 0) {
            return;
        }

        let transactionDesc = wrapper.find(formatSelector('transaction_description'));
        let orderExpires = wrapper.find(formatSelector('order_expires'));
        if (apiMethod === 'payment_api') {
            showPaymentApiFields(transactionDesc, orderExpires, wrapper);
        } else {
            showOrderApiField(transactionDesc, orderExpires, wrapper);
        }
    }

    /**
     * Shows fields for payment api
     *
     * @param {jQuery} transactionDesc
     * @param {jQuery} orderExpires
     * @param {jQuery} wrapper
     */
    function showPaymentApiFields(transactionDesc, orderExpires, wrapper) {
        transactionDesc.removeClass('hidden');
        wrapper.find('.mollie_transaction_description_title').removeClass('hidden');
        wrapper.find('.mollie_transaction_description_desc').removeClass('hidden');
        if (getUrlParameter('module') !== 'mollie_banktransfer') {
            orderExpires.addClass('hidden');
            wrapper.find('.mollie_order_expires_title').addClass('hidden');
            wrapper.find('.mollie_order_expires_desc').addClass('hidden');
        }
    }

    /**
     * Shows fields for orders api
     *
     * @param {jQuery} transactionDesc
     * @param {jQuery} orderExpires
     * @param {jQuery} wrapper
     */
    function showOrderApiField(transactionDesc, orderExpires, wrapper) {
        transactionDesc.addClass('hidden');
        wrapper.find('.mollie_transaction_description_title').addClass('hidden');
        wrapper.find('.mollie_transaction_description_desc').addClass('hidden');

        orderExpires.removeClass('hidden');
        wrapper.find('.mollie_order_expires_title').removeClass('hidden');
        wrapper.find('.mollie_order_expires_desc').removeClass('hidden');
    }

    /**
     * Format selector for fetching config field
     *
     * @param {string} configKey
     * @returns {string}
     */
    function formatSelector(configKey) {
        let moduleName = getUrlParameter('module');

        return '.module_payment_' + moduleName+ '_' + configKey;
    }

    /**
     * Returns query parameter value
     *
     * @param {string} key
     * @returns {null|string}
     */
    function getUrlParameter(key) {
        let pageUrl = window.location.search.substring(1),
            pageUrlVariables = pageUrl.split('&');

        for (let i = 0; i < pageUrlVariables.length; i++) {
            // parameter with key and value in format key=value
            let fullParameter = pageUrlVariables[i].split('=');

            if (fullParameter[0] === key) {
                return typeof fullParameter[1] === undefined ? null : decodeURIComponent(fullParameter[1]);
            }
        }

        return null;
    }
});
