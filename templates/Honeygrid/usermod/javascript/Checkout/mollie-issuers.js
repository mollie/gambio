(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let allIssuerLists = document.querySelectorAll('.mollie-issuers');


        showIssuerList();


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