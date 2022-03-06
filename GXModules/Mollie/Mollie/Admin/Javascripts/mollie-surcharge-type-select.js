$(document).ready(function () {
    let surchargeTypeChooser = $('.mollie-surcharge-type-select'),
        finalFieldHeight = 0;


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
        if (finalFieldHeight === 0 || finalFieldHeight === 24) {
            let oneDiv = surchargeFixedAmount.css('height');
            if (oneDiv) {
                finalFieldHeight = parseFloat(oneDiv.substring(0, oneDiv.indexOf('px')));
                if (!surchargeFixedAmount.hasClass('hidden')) {
                    finalFieldHeight += 24;
                }
            }
        }

        switch (surchargeType) {
            case 'no_fee':
                checkLastStatus(surchargeFixedAmount, surchargePercentage, surchargeLimit);
                surchargeFixedAmount.addClass('hidden');
                surchargePercentage.addClass('hidden');
                surchargeLimit.addClass('hidden');
                break;
            case 'fixed_fee':
                checkLastStatus(surchargeFixedAmount, surchargePercentage, surchargeLimit);
                surchargeFixedAmount.removeClass('hidden');
                surchargePercentage.addClass('hidden');
                surchargeLimit.addClass('hidden');
                addContentHeight(finalFieldHeight);
                break;
            case 'percentage':
                checkLastStatus(surchargeFixedAmount, surchargePercentage, surchargeLimit);
                surchargeFixedAmount.addClass('hidden');
                surchargePercentage.removeClass('hidden');
                surchargeLimit.removeClass('hidden');
                addContentHeight(finalFieldHeight * 2);
                break;
            case 'fixed_fee_and_percentage':
                checkLastStatus(surchargeFixedAmount, surchargePercentage, surchargeLimit);
                surchargeFixedAmount.removeClass('hidden');
                surchargePercentage.removeClass('hidden');
                surchargeLimit.removeClass('hidden');
                addContentHeight(finalFieldHeight * 3);
                break;
        }
    }

    /**
     * Checks previous unhidden fields and shortens the contents by their height
     *
     * @param surchargeFixedAmount
     * @param surchargePercentage
     * @param surchargeLimit
     */
    function checkLastStatus(surchargeFixedAmount, surchargePercentage, surchargeLimit) {
        if (!surchargeFixedAmount.hasClass('hidden')) {
            removeContentHeight(finalFieldHeight);
        }
        if (!surchargePercentage.hasClass('hidden')) {
            removeContentHeight(finalFieldHeight);
        }
        if (!surchargeLimit.hasClass('hidden')) {
            removeContentHeight(finalFieldHeight);
        }
    }

    /**
     * Adds content height
     * @param height
     */
    function addContentHeight(height) {
        let contentHeight = $('.boxCenterWrapper').css('height');
        if (contentHeight) {
            let contentNumber = parseFloat(contentHeight.substring(0, contentHeight.indexOf('px'))) + height;
            $('.boxCenterWrapper').css('height', contentNumber + 'px');
        }
    }

    /**
     * Shortens the height of the content
     * @param height
     */
    function removeContentHeight(height) {
        let contentHeight = $('.boxCenterWrapper').css('height');
        if (contentHeight) {
            let contentNumber = parseFloat(contentHeight.substring(0, contentHeight.indexOf('px'))) - height;
            $('.boxCenterWrapper').css('height', contentNumber + 'px');
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
