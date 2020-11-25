(function() {
    document.addEventListener("DOMContentLoaded", function () {

        let submitButton = document.querySelector('#checkout_payment').querySelector('input[type=submit]');

        if (submitButton) {
            submitButton.addEventListener('click', function () {
                let selectedMethod =  document.querySelector('input[name=payment]:checked').value;
                let issuers = document.querySelector('.' + selectedMethod).querySelector('#mollie-issuers');
                if (issuers) {
                    let selectedIssuer = getSelectedIssuer(issuers);
                    let data = {"issuer": selectedIssuer};
                    MollieHttpClient.http.post('/shop.php?do=MollieIssuerList', data);
                }
            })
        }

        function getSelectedIssuer(issuersWrapper) {
            let type = document.getElementById('mollie-list-type').value;
            if (type === 'dropdown') {
                let issuerDropdown = issuersWrapper.querySelector('select[name=mollie-issuer-dropdown]');

                return issuerDropdown.options[issuerDropdown.selectedIndex].value;
            }

            return issuersWrapper.querySelector('input[name=mollie-issuer-list]:checked').value;
        }
    });
})();