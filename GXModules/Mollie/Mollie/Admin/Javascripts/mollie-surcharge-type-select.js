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
                surchargeFixedAmount.addClass('hidden');
                surchargePercentage.addClass('hidden');
                surchargeLimit.addClass('hidden');
                break;
            case 'fixed_fee':
                surchargeFixedAmount.removeClass('hidden');
                surchargePercentage.addClass('hidden');
                surchargeLimit.addClass('hidden');
                setContentHeight();
                break;
            case 'percentage':
                surchargeFixedAmount.addClass('hidden');
                surchargePercentage.removeClass('hidden');
                surchargeLimit.removeClass('hidden');
                setContentHeight();
                break;
            case 'fixed_fee_and_percentage':
                surchargeFixedAmount.removeClass('hidden');
                surchargePercentage.removeClass('hidden');
                surchargeLimit.removeClass('hidden');
                setContentHeight();
                break;
        }
    }

    /**
     * Sets the configuration content height
     */
    function setContentHeight() {
        let mollieSwitcher = $('.mollie-switcher');
        if(mollieSwitcher.length === 0){
            $('.boxCenterWrapper').css('height', '190.3em');
        } else{
            $('.boxCenterWrapper').css('height', '228.4em');
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
