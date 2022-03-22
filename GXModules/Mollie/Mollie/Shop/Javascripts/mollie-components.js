var MollieComponents = window.MollieComponents || {};

(function () {
    /**
     *
     * @constructor
     */
    function CreditCardService() {
        this.mount = mount;
        this.unmount = unmount;

        function mount(cardWrapper) {
            if (isMounted()) {
                return;
            }

            const mollie = init(cardWrapper);
            let useSavedCreditCard = document.getElementById('mollie_creditcard-use-saved-credit-card-checkbox'),
                saveCreditCardData = document.getElementById('mollie_creditcard-save-credit-card-checkbox'),
                useSavedCreditCardWrapper = document.getElementsByClassName('form-group--useSavedCreditCardCheckbox')[0],
                descriptionOfCreditCard = document.querySelector('.mollie_creditcard .payment-module-description');

            if (descriptionOfCreditCard) {
                descriptionOfCreditCard.innerHTML = document.getElementById('mollie_creditcard-description-hidden-input').value;
                descriptionOfCreditCard.classList.add('hidden');
            }

            saveCreditCardData.addEventListener('change', function (event) {
                event.stopPropagation();
            });

            if (useSavedCreditCardWrapper.classList.contains('hidden')) {
                useSavedCreditCard.value = null;
                showComponents(cardWrapper, mollie);
            } else {
                useSavedCreditCard.addEventListener('change', handleCheckboxUseSavedChange);

                if (useSavedCreditCard.checked === false) {
                    showComponents(cardWrapper, mollie);
                    document.getElementsByClassName('form-group--saveCreditCardCheckbox')[0].classList.remove('hidden');
                } else {
                    hideComponents();
                    if (descriptionOfCreditCard) {
                        descriptionOfCreditCard.classList.remove('hidden');
                    }
                }
            }

            addSubmitPaymentListener(cardWrapper, mollie);

            function handleCheckboxUseSavedChange(event) {
                event.stopPropagation();

                if (this.checked) {
                    if (descriptionOfCreditCard) {
                        descriptionOfCreditCard.classList.remove('hidden');
                    }
                    hideComponents();
                } else if (document.getElementsByClassName('form-group--cardHolder')[0].classList.contains('hidden')) {
                    document.getElementsByClassName('form-group--saveCreditCardCheckbox')[0].classList.remove('hidden');
                    if (descriptionOfCreditCard) {
                        descriptionOfCreditCard.classList.add('hidden');
                    }
                    showComponents(cardWrapper, mollie);
                }
            }
        }

        function hideComponents() {
            document.getElementsByClassName('form-group--cardHolder')[0].classList.add('hidden');
            document.getElementsByClassName('form-group--cardNumber')[0].classList.add('hidden');
            document.getElementsByClassName('form-group--expiryDate')[0].classList.add('hidden');
            document.getElementsByClassName('form-group--verificationCode')[0].classList.add('hidden');
            document.getElementsByClassName('form-group--saveCreditCardCheckbox')[0].classList.add('hidden');
        }

        function showComponents(cardWrapper, mollie) {
            document.getElementsByClassName('form-group--cardHolder')[0].classList.remove('hidden');
            document.getElementsByClassName('form-group--cardNumber')[0].classList.remove('hidden');
            document.getElementsByClassName('form-group--expiryDate')[0].classList.remove('hidden');
            document.getElementsByClassName('form-group--verificationCode')[0].classList.remove('hidden');

            const cardHolder = createMollieComponent('cardHolder', 'card-holder', cardWrapper, mollie);
            const cardNumber = createMollieComponent('cardNumber', 'card-number', cardWrapper, mollie);
            const expDate = createMollieComponent('expiryDate', 'expiry-date', cardWrapper, mollie);
            const verificationCode = createMollieComponent('verificationCode', 'verification-code', cardWrapper, mollie);

            addValidationListeners(cardHolder, buildIdSelector('card-holder', cardWrapper));
            addValidationListeners(cardNumber, buildIdSelector('card-number', cardWrapper));
            addValidationListeners(expDate, buildIdSelector('expiry-date', cardWrapper));
            addValidationListeners(verificationCode, buildIdSelector('verification-code', cardWrapper));
        }


        function unmount() {
            try {
                let mollieComponents = document.querySelectorAll('.mollie-component');
                for (let i = 0; i < mollieComponents.length; i++) {
                    mollieComponents[i].remove();
                }

                let mollieControllers = document.querySelectorAll('.mollie-components-controller');
                for (let i = 0; i < mollieControllers.length; i++) {
                    mollieControllers[i].remove();
                }

            } catch (e) {

            }

        }

        function addSubmitPaymentListener(cardWrapper, mollie) {
            let checkoutForm = document.querySelector('#checkout_payment');
            let useSavedCreditCard = document.querySelector('#mollie_creditcard-use-saved-credit-card-checkbox');

            checkoutForm.addEventListener('submit', async event => {
                if (getSelectedMethod() === cardWrapper.getAttribute('data-method-id')
                    && (useSavedCreditCard.checked === false || useSavedCreditCard.classList.contains('hidden'))) {
                    event.preventDefault();
                    const {token, error} = await mollie.createToken();
                    if (error) {
                        return;
                    }

                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.value = token;
                    input.name = 'mollieCardToken';
                    checkoutForm.appendChild(input);

                    checkoutForm.submit();
                } else {
                    checkoutForm.submit();
                }
            });
        }

        function addValidationListeners(element, selector) {
            var wrapperElement = document.querySelector(selector);
            element.addEventListener("change", event => {
                wrapperElement.parentNode.classList.toggle('is-dirty', event.dirty);
            });

            element.addEventListener("focus", () => {
                wrapperElement.parentNode.classList.toggle('has-focus', true);
            });

            element.addEventListener("blur", () => {
                wrapperElement.parentNode.classList.toggle('has-focus', false);
            });

        }

        function createMollieComponent(type, selector, cardWrapper, mollie) {
            let paymentMethod = cardWrapper.getAttribute('data-method-id');
            let baseSelector = '#' + paymentMethod + '-' + selector;
            let errorSelector = '#' + paymentMethod + '-' + selector + '-error';

            let component = mollie.createComponent(type);
            component.mount(baseSelector);

            const cardHolderError = document.querySelector(errorSelector);

            component.addEventListener("change", event => {
                if (event.error && event.touched) {
                    cardHolderError.textContent = event.error;
                } else {
                    cardHolderError.textContent = "";
                }
            });

            return component;
        }


        function getSelectedMethod() {
            let selectedMethod = document.querySelector('input[name=payment]:checked');
            if (!selectedMethod && isCreditCardOnlyPayment()) {
                selectedMethod = document.querySelector('input[name=payment]');
            }

            return selectedMethod ? selectedMethod.value : null;
        }

        /**
         *
         * @param baseSelector
         * @param cardWrapper
         * @returns {string}
         */
        function buildIdSelector(baseSelector, cardWrapper) {
            let paymentMethod = cardWrapper.getAttribute('data-method-id');

            return '#' + paymentMethod + '-' + baseSelector;
        }

        /**
         *
         * @param cardWrapper
         * @returns {*}
         */
        function init(cardWrapper) {
            return Mollie(
                cardWrapper.getAttribute('data-profile-id'),
                {
                    locale: cardWrapper.getAttribute('data-language-code'),
                    testmode: cardWrapper.getAttribute('data-test-mode') === '1',
                }
            );
        }

        /**
         *
         * @returns {boolean}
         */
        function isMounted() {
            return document.querySelectorAll('.mollie-component').length > 0;
        }

        function isCreditCardOnlyPayment() {
            let paymentMethods = document.querySelectorAll('li.list-group-item');

            return paymentMethods.length === 1 && paymentMethods[0].classList.contains('mollie_creditcard');
        }
    }

    MollieComponents.creditCard = new CreditCardService();
})();
