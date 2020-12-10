$(document).ready(function () {
    $('#mollie-payment-link').click(function () {
        let orderId = $(this).parents('tr').attr('id') || $('body').find('#gm_order_id').val();
        let serverUrl = 'admin.php?do=MolliePaymentLink&orders_id=' + orderId;

        Mollie.modal.openModal(serverUrl,getModalConfig());
    })

    function init() {
        $('#process-payment').click(function () {
            Mollie.copyToClipboard.copy($('#mollie-payment-link-url').val())
        });
    }

    function getModalConfig() {
        let label = $('#txt-mollie-copy-to-clipboard').val();
        let title = $('#txt-mollie-payment-link').val();
        let buttons = [
            Mollie.modal.createCancelButton(),
            Mollie.modal.createActionButton('process-payment', label)
        ];

        var initialization = init;

        return {
            title: title,
            buttons: buttons,
            dialogClass: 'gx-container',
            width: 550,
            height: 300,
            resizable: false,
            modal: true,
            onLoad: function () {
                initialization()
            }
        };
    }
});
