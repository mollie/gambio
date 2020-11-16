$(document).ready(function () {
    let lineTable = $('.mollie-line-table');
    let qtyInputElements = $(".mollie-qty-input");
    let qtyInputDisabled = $(".mollie-qty-input:disabled");
    let submitButton = $(".mollie-dialog-submit");

    checkIsModalProcessable();

    /**
     * On tab change, validate all inputs
     */
    $(document).on('mollie-tab-changed-event', function (event, action) {
        if (action !== 'payment-details-table') {
            checkAllQuantities();
        }
    })

    function checkIsModalProcessable() {
        if (lineTable.is(':visible') && qtyInputElements.length === qtyInputDisabled.length) {
            submitButton.prop('disabled', true);
            $('.mollie-popup-error-msg').removeClass('mollie-hidden');
        }
    }

    qtyInputElements.change(function() {
        checkAllQuantities();

        return false;
    });

    function checkAllQuantities() {
        let disableSubmitButton = false;
        let allInputsZero = true;
        qtyInputElements.each(function (){
            let rowElement = $(this).closest('tr');
            let orderedQty = parseInt(rowElement.find('.mollie-ordered-qty').text());
            let processed = parseInt(rowElement.find('.mollie-processed-qty').text());
            let inputValue = parseInt($(this).val());
            let hasError = inputValue < 0 || (inputValue + processed) > orderedQty;
            if (inputValue > 0) {
                allInputsZero = false;
            }

            let errorClass = 'mollie-input-error';
            hasError ? $(this).addClass(errorClass) : $(this).removeClass(errorClass);
            if (hasError) {
                disableSubmitButton = true;
            }

        });

        disableSubmitButton = disableSubmitButton || allInputsZero;

        submitButton.prop('disabled', disableSubmitButton);
    }
});
