$(document).ready(function () {
    $('#mollie-refund-button').click(function () {
        let orderId = $(this).parents('tr').attr('id') || $('body').find('#gm_order_id').val();
        let serverUrl = 'admin.php?do=MollieRefund&orders_id=' + orderId;

        MollieHttpClient.modal.openModal(serverUrl, getModalConfig());
    })

    function getModalConfig() {
        let label = $('#txt-mollie-refund').val();
        let title = $('#txt-mollie-refunds').val();
        let buttons = [
            MollieHttpClient.modal.createCancelButton(),
            MollieHttpClient.modal.createActionButton('process-refund', label)
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

    /**
     * Modal content loaded
     */
    function init() {
        let qtyInputElements = $(".mollie-qty-input");
        let qtyInputDisabled = $(".mollie-qty-input:disabled");
        let amountAvailable = $("#mollie-available");
        let refundButton = $("#process-refund");
        let refundedMessage = $('.mollie-popup-error-msg');
        let refundAmountInput = $('#refund-payment-amount');

        /**
         * On tab change, validate payment amount
         */
        $(document).on('mollie-tab-changed-event', function (event, action) {
            if (action === 'payment-details-table') {
                initPaymentTab();
            }
        })

        if (isTotalAmountRefunded() || isAllLinesRefunded()) {
            $('#mollie-popup input').prop('disabled', true);
            refundButton.prop('disabled', true);
            refundedMessage.removeClass('mollie-hidden');
        }

        function initPaymentTab() {
            if (isTotalAmountRefunded() || isAllLinesRefunded()) {
                $('#mollie-popup input').prop('disabled', true);
                refundButton.prop('disabled', true);
                refundedMessage.removeClass('mollie-hidden');
            } else {
                validateAmount(refundAmountInput);
                refundAmountInput.change(function () {
                    validateAmount($(this));
                });
            }
        }
        /**
         * Check if total amount is refunded
         *
         * @returns {boolean}
         */
        function isTotalAmountRefunded() {
            return parseFloat(amountAvailable.val()) === 0;
        }

        /**
         * Check if line item elements exits and if all are disabled
         *
         * @returns {boolean}
         */
        function isAllLinesRefunded() {
            return qtyInputElements.length > 0 &&
                qtyInputElements.length === qtyInputDisabled.length;
        }

        function validateAmount(target) {
            let value = target.val();
            let maxValue = parseFloat($('#mollie-amount-available').text());
            let disable =  isAmountInputValid(value, maxValue);

            refundButton.prop('disabled', disable);
            let errorClass = 'mollie-input-error';
            disable ? target.addClass(errorClass) : target.removeClass(errorClass);
        }

        /**
         *
         * @param {float} inputValue
         * @param {float} maxValue
         *
         * @returns {boolean}
         */
        function isAmountInputValid(inputValue, maxValue) {
            return isNaN(inputValue) || inputValue <= 0 || inputValue > maxValue;
        }

        refundButton.click(function () {
            refundSubmitHandler();
        });

        function refundSubmitHandler() {
            let data = createRequestData();
            let url = $('#mollie-process-refund-url').val();

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

        function createRequestData() {
            let activeTab = $('.active-tab').attr('data-action');
            let ordersApiUsed = activeTab === 'order-details-table';
            let data = ordersApiUsed ? getLineItemsData() : getPaymentData();

            data.ordersApiUsed = ordersApiUsed;

            return data;
        }

        function getLineItemsData() {
            return  {'lines': MollieHttpClient.orderLines.buildOrderLines('.mollie-refund-item-row')};
        }

        function getPaymentData() {
            return  {
                'amount': {
                    'value': refundAmountInput.val(),
                    'currency': $("#mollie-refund-currency").val()
                },

                'description' : $('#refund-desc').val()
            };
        }
    }
});
