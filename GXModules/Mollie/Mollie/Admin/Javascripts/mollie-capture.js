$(document).ready(function () {
    $('#mollie-capture-button').click(function () {
        let transactionId = $(this).data('transaction-id');
        let serverUrl = 'admin.php?do=MollieCapture&transaction_id=' + transactionId;

        Mollie.modal.openModal(serverUrl, getModalConfig());
    });

    function getModalConfig() {
        let label = $('#txt-captures').val();
        let title = $('#txt-captures').val();
        let buttons = [
            Mollie.modal.createCancelButton(),
            Mollie.modal.createActionButton('mollie-process-captures', label)
        ];

        var initialization = init;

        return {
            title: title,
            buttons: buttons,
            dialogClass: 'gx-container',
            width: 1000,
            height: 700,
            resizable: false,
            modal: true,
            onLoad: function () {
                initialization()
            }
        };
    }

    function init() {
        let initialTotalPaidAmount = parseFloat($('#mollie-total-for-capture').val());
        let leftToBeCapturedAmount = parseFloat($('#mollie-left-for-capture-amount').val());

        $("#mollie-total-for-capture").on("change", function () {
            let currentValue = parseFloat($(this).val());
            disableSubmitButton(currentValue, initialTotalPaidAmount, leftToBeCapturedAmount);
        });

        $('#mollie-process-captures').click(function () {
            captureSubmitHandler();
        });
    }

    /**
     *
     * @param value
     * @param totalPaidAmount
     * @param leftToBeCapturedAmount
     */
    function disableSubmitButton(value, totalPaidAmount, leftToBeCapturedAmount) {
        let processCaptureButton = $('#mollie-process-captures');
        let shouldBeDisabled = value > totalPaidAmount || value > leftToBeCapturedAmount;

        processCaptureButton.prop('disabled', shouldBeDisabled);
    }

    function captureSubmitHandler() {
        let data = getRequestData();
        let url = $('#mollie-process-capture-url').val();

        $.ajax({
            url: url,
            type: 'post',
            data: JSON.stringify(data),
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            processData: false,
            success: function (response) {
                if (response.success) {
                    location.reload();
                }
            },
        });
    }

    function getRequestData() {
        return {
            'transactionId': $('#mollie-capture-button').data('transaction-id'),
            'amountForCapture': $("#mollie-total-for-capture").val()
        };
    }
});
