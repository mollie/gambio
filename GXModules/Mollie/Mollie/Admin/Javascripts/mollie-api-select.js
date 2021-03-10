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

        if (apiMethod === 'payment_api') {
            wrapper.find(formatSelector('transaction_description')).removeClass('hidden');
            wrapper.find('.mollie_transaction_description_title').removeClass('hidden');
            wrapper.find('.mollie_transaction_description_desc').removeClass('hidden');
            wrapper.find(formatSelector('due_date')).removeClass('hidden');
            wrapper.find('.mollie_due_date_title').removeClass('hidden');
            wrapper.find('.mollie_due_date_desc').removeClass('hidden');
            wrapper.find(formatSelector('order_expires')).addClass('hidden');
            wrapper.find('.mollie_order_expires_title').addClass('hidden');
            wrapper.find('.mollie_order_expires_desc').addClass('hidden');
        } else {
            wrapper.find(formatSelector('transaction_description')).addClass('hidden');
            wrapper.find('.mollie_transaction_description_title').addClass('hidden');
            wrapper.find('.mollie_transaction_description_desc').addClass('hidden');
            wrapper.find(formatSelector('due_date')).addClass('hidden');
            wrapper.find('.mollie_due_date_title').addClass('hidden');
            wrapper.find('.mollie_due_date_desc').addClass('hidden');
            wrapper.find(formatSelector('order_expires')).removeClass('hidden');
            wrapper.find('.mollie_order_expires_title').removeClass('hidden');
            wrapper.find('.mollie_order_expires_desc').removeClass('hidden');
        }
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
