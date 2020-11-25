$(document).ready(function () {
    $('#mollie-shipment-button').click(function () {
        let orderId = $(this).parents('tr').attr('id') || $('body').find('#gm_order_id').val();
        let serverUrl = 'admin.php?do=MollieShipment&orders_id=' + orderId;

        MollieHttpClient.modal.openModal(serverUrl, getModalConfig());
    })

    function getModalConfig() {
        let label = $('#txt-submit-shipments').val();
        let title = $('#txt-mollie-shipments').val();
        let buttons = [
            MollieHttpClient.modal.createCancelButton(),
            MollieHttpClient.modal.createActionButton('process-shipment', label)
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
        if (!$('#mollie-is-shippable').val()) {
            $("#process-shipment").prop('disabled', true);
        }

        $("#mollie-carrier").change(function() {
            checkTrackingInput($(this), $('#mollie-tracking-code'));
        });

        $("#mollie-tracking-code").change(function() {
            checkTrackingInput($(this), $("#mollie-carrier"));
        });


        function checkTrackingInput(changedInputElement, pairedInputElement) {
            let disableSubmitButton = false;
            let pairedInputElementError = false;
            let changedInputElementError = false;
            if (changedInputElement.val()) {
                if (!pairedInputElement.val()) {
                    disableSubmitButton = true;
                    pairedInputElementError = true;
                }
            } else {
                if (pairedInputElement.val()) {
                    disableSubmitButton = true;
                    changedInputElementError = true;
                }
            }

            let errorClass = 'mollie-input-error';
            changedInputElementError ? changedInputElement.addClass(errorClass) : changedInputElement.removeClass(errorClass);
            pairedInputElementError ? pairedInputElement.addClass(errorClass) : pairedInputElement.removeClass(errorClass);

            $("#process-shipment").prop('disabled', disableSubmitButton);
        }

        $('#process-shipment').click(function () {
            shipmentSubmitHandler();
        });

        function shipmentSubmitHandler() {
            let data = getRequestData();
            let url = $('#mollie-process-shipment-url').val();

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
                'lines': MollieHttpClient.orderLines.buildOrderLines('.mollie-ship-item-row'),
                'tracking': getTrackingData()
            };
        }

        function getTrackingData() {
            return {
                'carrier': $('#mollie-carrier').val(),
                'code': $('#mollie-tracking-code').val(),
                'url': $('#mollie-tracking-url').val()
            };
        }
    }
});
