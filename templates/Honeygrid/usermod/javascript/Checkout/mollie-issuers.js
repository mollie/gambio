(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let issuerListWrappers = document.querySelectorAll('.mollie-issuer-list-wrapper');
        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let allIssuerLists = document.querySelectorAll('.mollie-issuers');

        showIssuerList();
        showIssuersIfOnlyPaymentMethod();

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
            paymentMethods[i].onclick = function () {
                setTimeout(showIssuerList, 100);
            };
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

            // in case when only one payment method is rendering, input type is hidden
            selectedMethod = document.querySelector('input[name=payment]');
            if (selectedMethod.type === 'hidden') {
                return document.querySelector('.' + selectedMethod.value).querySelector('.mollie-issuers');
            }

            return null;
        }

        /**
         * Display issuer list in case of only payment method
         */
        function showIssuersIfOnlyPaymentMethod() {
            if (paymentMethods.length !== 1) {
                return;
            }

            let issuerListWrapper = document.querySelector('.mollie-issuers');
            if (issuerListWrapper) {
                issuerListWrapper.classList.remove('mollie-hidden');
            }
        }
    });
})();