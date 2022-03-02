$(document).ready(function () {
    let surchargeTypeChooser = $('.mollie-surcharge-type-select');

    if (surchargeTypeChooser.length) {
        // initial fields display
        displayFieldsBasedOnSurchargeType(surchargeTypeChooser.val());

        // adding change listener
        surchargeTypeChooser.change(function () {
            displayFieldsBasedOnSurchargeType(($(this).val()))
        })

    }

    /**
     * Displays fields based on the selected surcharge type
     *
     * @param {string} surchargeType
     */
    function displayFieldsBasedOnSurchargeType(surchargeType) {
        let wrapper = $('#configuration-box-form');
        if (wrapper.length === 0) {
            return;
        }

        let surchargeFixedAmount = wrapper.find(formatSelector('surcharge_fixed_amount')),
            surchargePercentage = wrapper.find(formatSelector('surcharge_percentage')),
            surchargeLimit = wrapper.find(formatSelector('surcharge_limit'));
        switch (surchargeType) {
            case 'no_fee':
                hideFields(wrapper, surchargeFixedAmount, 'mollie_surcharge_fixed_amount_desc');
                hideFields(wrapper, surchargePercentage, 'mollie_surcharge_percentage_desc');
                hideFields(wrapper, surchargeLimit, 'mollie_surcharge_limit_desc');
                break;
            case 'fixed_fee':
                showFields(surchargeFixedAmount, 'mollie_surcharge_fixed_amount_desc');
                hideFields(wrapper, surchargePercentage, 'mollie_surcharge_percentage_desc');
                hideFields(wrapper, surchargeLimit, 'mollie_surcharge_limit_desc');
                break;
            case 'percentage':
                hideFields(wrapper, surchargeFixedAmount, 'mollie_surcharge_fixed_amount_desc');
                showFields(surchargePercentage, 'mollie_surcharge_percentage_desc');
                showFields(surchargeLimit, 'mollie_surcharge_limit_desc');
                break;
            case 'fixed_fee_and_percentage':
                showFields(surchargeFixedAmount, 'mollie_surcharge_fixed_amount_desc');
                showFields(surchargePercentage, 'mollie_surcharge_percentage_desc');
                showFields(surchargeLimit, 'mollie_surcharge_limit_desc');
                break;
        }
    }

    function showFields(element, hiddenInputId) {
        if (element.hasClass('hidden')) {
            element.removeClass('hidden');
            element[0].previousElementSibling.style.display = 'block';
            let hiddenApprovalTextElement = $('#' + hiddenInputId);
            if (hiddenApprovalTextElement.length > 0) {
                element[0].before(hiddenApprovalTextElement[0].value);
            }

            hiddenApprovalTextElement.remove();
        }
    }

    function hideFields(wrapper, element, hiddenInputId) {
        if (!element.hasClass('hidden')) {
            element.addClass('hidden');
            element[0].previousElementSibling.style.display = 'none';
            wrapper.append(
                $(document.createElement('input')).prop({
                    type: 'hidden',
                    id: hiddenInputId,
                    value: element[0].previousSibling.wholeText,
                })
            );

            element[0].previousSibling.remove();
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

        return '.module_payment_' + moduleName + '_' + configKey;
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
