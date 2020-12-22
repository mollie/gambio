(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let allIssuerLists = document.querySelectorAll('.mollie-issuers');
        let issuerListWrappers = document.querySelectorAll('.mollie-issuer-list-wrapper');

        showIssuerList();

        for (let i = 0; i < issuerListWrappers.length; i++) {
            addIssuerListListeners(issuerListWrappers[i]);
        }

        function addIssuerListListeners(issuerListWrapper) {
            let issuers = issuerListWrapper.querySelectorAll('.mollie-issuer-list');
            let issuerListHiddenInput = issuerListWrapper.querySelector('input[type="hidden"]');
            setSelectedIssuer();
            for (let i = 0; i < issuers.length; i++) {
                issuers[i].addEventListener('click', function (event) {
                    disableAll(issuers);
                    event.target.checked = true;
                    issuerListHiddenInput.value = event.target.value;
                    event.stopPropagation();
                });
            }


            function disableAll(issuers) {
                for (let i = 0; i < issuers.length; i++) {
                    issuers[i].checked = false;
                }
            }

            function setSelectedIssuer() {
                let selectedIssuer = issuerListWrapper.querySelector('input[type="radio"]:checked')
                issuerListHiddenInput.value = selectedIssuer.value;
            }
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
