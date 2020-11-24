(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let allIssuerLists = document.querySelectorAll('.mollie-issuers');
        let submitButton = document.querySelector('#checkout_payment').querySelector('input[type=submit]');

        showIssuerList();

        if (submitButton) {
            submitButton.addEventListener('click', function () {
                let issuers = getIssuerListForSelectedMethod();
                if (issuers) {
                    let selectedIssuer = getSelectedIssuer(issuers);
                    let data = {"issuer": selectedIssuer};
                    Mollie.http.post('/shop.php?do=MollieIssuerList', data);
                }
            })
        }

        function getSelectedIssuer(issuersWrapper) {
            let type = issuersWrapper.querySelector('.mollie-list-type').value;
            if (type === 'dropdown') {
                let issuerDropdown = issuersWrapper.querySelector('select[name=mollie-issuer-dropdown]');

                return issuerDropdown.options[issuerDropdown.selectedIndex].value;
            }

            return issuersWrapper.querySelector('input[name=mollie-issuer-list]:checked').value;
        }

        for (let i = 0; i < paymentMethods.length; i++) {
            paymentMethods[i].addEventListener('click', function () {
                showIssuerList();
            });
        }

        function showIssuerList() {
            hideAllIssuers();
            let issuerList = getIssuerListForSelectedMethod();
            if (issuerList) {
                issuerList.classList.remove('mollie-hidden');
            }
        }

        function hideAllIssuers() {
            for (let i = 0; i < allIssuerLists.length; i++) {
                allIssuerLists[i].classList.add('mollie-hidden');
            }
        }

        function getIssuerListForSelectedMethod() {
            let selectedMethod = document.querySelector('input[name=payment]:checked');
            if (selectedMethod) {
                return document.querySelector('.' + selectedMethod.value).querySelector('.mollie-issuers');
            }

            return null;
        }
    });
})();