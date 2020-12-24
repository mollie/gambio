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
            // mount components
            const cardHolder = createMollieComponent('cardHolder', 'card-holder', cardWrapper, mollie);
            const cardNumber = createMollieComponent('cardNumber', 'card-number', cardWrapper, mollie);
            const expDate = createMollieComponent('expiryDate', 'expiry-date', cardWrapper, mollie);
            const verificationCode = createMollieComponent('verificationCode', 'verification-code', cardWrapper, mollie);


            //add validation listeners
            addValidationListeners(cardHolder, buildIdSelector('card-holder', cardWrapper));
            addValidationListeners(cardNumber, buildIdSelector('card-number', cardWrapper));
            addValidationListeners(expDate, buildIdSelector('expiry-date', cardWrapper));
            addValidationListeners(verificationCode, buildIdSelector('verification-code', cardWrapper));

            addSubmitPaymentListener(cardWrapper, mollie);
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
            checkoutForm.addEventListener('submit', async event => {
                if (getSelectedMethod() === cardWrapper.getAttribute('data-method-id')) {
                    event.preventDefault();
                    const { token, error } = await mollie.createToken();
                    if (error) {
                        return;
                    }

                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.value = token;
                    input.name = 'mollieCardToken';
                    checkoutForm.appendChild(input);

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
            let errorSelector = '#' + paymentMethod+ '-' + selector + '-error';

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
            let selectedMethod =  document.querySelector('input[name=payment]:checked');

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
        function init (cardWrapper) {
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
    }

    MollieComponents.creditCard = new CreditCardService();
})();