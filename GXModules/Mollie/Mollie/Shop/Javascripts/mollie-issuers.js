(function () {
    document.addEventListener("DOMContentLoaded", function () {
        let issuerListWrappers = document.querySelectorAll('.mollie-issuer-list-wrapper');
        const paymentMethods = document.querySelectorAll('input[type="radio"]');

        //switch to iDeal 2.0 without issuers
        paymentMethods.forEach(function (method) {
            if (method.value.includes('mollie_')) {
                if (method.value === 'mollie_ideal') {
                    if (method.checked) {
                        hideIdealCheckoutPaymentForm();
                    }
                    method.addEventListener('click', function () {
                        hideIdealCheckoutPaymentForm();
                    });
                }
            }
        });

        //in case if ideal is the only available payment method, it won't be shown as radio button but as li element
        const issuerMethod = document.querySelector('li.mollie_ideal');
        if (issuerMethod) {
            hideIdealCheckoutPaymentForm();
        }

        for (let i = 0; i < issuerListWrappers.length; i++) {
            addIssuerListListeners(issuerListWrappers[i]);
        }

        let checkoutForm = document.querySelector('#checkout_payment');
        checkoutForm.addEventListener('submit', async event => {
            //skip checking issuer selection for iDeal 2.0 payment method
            let activeMethod = getActiveMethod();
            if (activeMethod.classList.contains('mollie_ideal')) {
                return;
            }

            if (!isIssuersSelected()) {
                showIssuerErrorMessage();
                event.preventDefault();
                event.stopPropagation();
            }
        });

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
                if (selectedIssuer) {
                    issuerListHiddenInput.value = selectedIssuer.value;
                }
            }
        }

        /**
         * Check if issuer is selected (if the payment method with the issuer's list is active)
         *
         * @returns {boolean}
         */
        function isIssuersSelected() {
            let issuerListWrapper = getActiveIssuerListWrapper();
            if (issuerListWrapper) {
                return issuerListWrapper.querySelectorAll('input[type="radio"]:checked').length > 0;
            }

            return true;
        }

        /**
         * Displays error message in the issuer list box
         */
        function showIssuerErrorMessage() {
            let issuerListWrapper = getActiveIssuerListWrapper();
            if (issuerListWrapper) {
                let issuerErrorMessage = issuerListWrapper.querySelector('.issuer-not-selected');
                if (issuerErrorMessage) {
                    issuerErrorMessage.classList.remove('hidden')
                }

                scrollToActiveMethod();
            }
        }

        /**
         * Returns issuer list wrapper of the selected payment method
         *
         * @returns {null|Element}
         */
        function getActiveIssuerListWrapper() {
            let activeMethodWrapper = getActiveMethod();
            if (activeMethodWrapper) {
                return activeMethodWrapper.querySelector('.mollie-issuer-list-wrapper');
            }

            return null;
        }

        function scrollToActiveMethod() {
            let activeMethodWrapper = getActiveMethod();
            if (activeMethodWrapper) {
                activeMethodWrapper.scrollIntoView();
            }
        }

        function getActiveMethod() {
            return document.querySelector('.list-group-item.active');
        }

        function hideIdealCheckoutPaymentForm() {
            let checkoutPaymentForm = document.querySelector('.checkout-payment-form');
            if (checkoutPaymentForm) {
                checkoutPaymentForm.style.display = 'none';
            }
        }

    });
})();
