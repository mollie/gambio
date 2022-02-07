$(document).ready(function () {
    let mollieSwitcher = $('.mollie-switcher');

    mollieSwitcher.each(function () {
        let id = this.id.substring(0, this.id.indexOf('_switcher')),
            checkBoxInput = $('#' + id);

        // initial fields display
        if (checkBoxInput.prop('checked') === true) {
            $(this).addClass('checked');
            if (id.includes('single_click')) {
                displayFields(true)
            }
        } else {
            $(this).removeClass('checked');
            if (id.includes('single_click')) {
                displayFields(false);
            }
        }

        // adding click listener
        $(this).unbind('click');
        $(this).on("click", changeStatus);
    });

    function changeStatus() {
        let id = this.id.substring(0, this.id.indexOf('_switcher')),
            checkBoxInput = $('#' + id);
        if (checkBoxInput.prop('checked') === true) {
            checkBoxInput.prop('checked', false);
            $(this).removeClass('checked');
            if (id.includes('single_click')) {
                displayFields(false)
            }
        } else {
            checkBoxInput.prop('checked', true);
            $(this).addClass('checked');
            if (id.includes('single_click')) {
                displayFields(true)
            }
        }
    }

    /**
     * Displays or hide fields depending on single click payment status
     *
     */
    function displayFields(singleClickStatus) {
        let wrapper = $('#configuration-box-form');
        if (wrapper.length === 0) {
            return;
        }

        let approvalText = wrapper.find(formatSelector('single_click_approval_text')),
            description = wrapper.find(formatSelector('single_click_description'));
        if (singleClickStatus) {
            approvalText.removeClass('hidden');
            description.removeClass('hidden');
        } else {
            approvalText.addClass('hidden');
            description.addClass('hidden');
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