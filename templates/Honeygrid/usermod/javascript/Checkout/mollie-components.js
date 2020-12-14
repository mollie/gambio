var MollieComponents = window.MollieComponents || {};

(function () {
    /**
     *
     * @param {HTMLElement} cardWrapper
     * @constructor
     */
    function CreditCardService(cardWrapper) {

        const mollie = init();

        // mount components
        const cardHolder = createMollieComponent('cardHolder', 'card-holder');
        const cardNumber = createMollieComponent('cardNumber', 'card-number');
        const expDate = createMollieComponent('expiryDate', 'expiry-date');
        const verificationCode = createMollieComponent('verificationCode', 'verification-code');

        //add validation listeners
        addValidationListeners(cardHolder, buildIdSelector('card-holder'));
        addValidationListeners(cardNumber, buildIdSelector('card-number'));
        addValidationListeners(expDate, buildIdSelector('expiry-date'));
        addValidationListeners(verificationCode, buildIdSelector('verification-code'));

        addSubmitPaymentListener();

        function addSubmitPaymentListener() {
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

        function createMollieComponent(type, selector) {
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
         * @returns {string}
         */
        function buildIdSelector(baseSelector) {
            let paymentMethod = cardWrapper.getAttribute('data-method-id');

            return '#' + paymentMethod + '-' + baseSelector;
        }

        function init () {
            return Mollie(
                cardWrapper.getAttribute('data-profile-id'),
                {
                    locale: cardWrapper.getAttribute('data-language-code'),
                    testmode: cardWrapper.getAttribute('data-test-mode') === '1',
                }
            );
        }
    }

    MollieComponents.creditCard = CreditCardService;
})();