var Mollie = window.Mollie || {};

(function () {
    function OrderLinesService() {
        this.buildOrderLines = buildOrderLines;

        /**
         *
         * @param {string} rowSelector
         */
        function buildOrderLines(rowSelector) {
            let lines = [];

            $(rowSelector).each(function () {
                let quantity = $(this).find('input.mollie-qty-input').val();
                if (parseInt(quantity) > 0) {
                    let item = {
                        'quantity': quantity,
                        'id': $(this).find('input.mollie-line-id').val()
                    }

                    lines.push(item)
                }
            });

            return lines;
        }
    }

    Mollie.orderLines = new OrderLinesService();
})();
