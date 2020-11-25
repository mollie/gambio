(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let checkoutForm = document.querySelector('#checkout_payment');
        let creditCardComponents = document.querySelector('#mollie-component-wrapper');

        if (isCreditCardMethod()) {
            creditCardComponents.classList.remove('mollie-hidden');
        }

        if (isCreditCardMethod()) {
            creditCardComponents.classList.remove('mollie-hidden');
        }

        for (let i = 0; i < paymentMethods.length; i++) {
            paymentMethods[i].addEventListener('click', function () {
                creditCardComponents.classList.add('mollie-hidden');
                if (isCreditCardMethod()) {
                    creditCardComponents.classList.remove('mollie-hidden');
                }
            });
        }


        /**
         * Create card holder input
         */
        const cardHolder = mollie.createComponent("cardHolder");
        cardHolder.mount("#card-holder");

        const cardHolderError = document.getElementById("card-holder-error");

        cardHolder.addEventListener("change", event => {
            if (event.error && event.touched) {
                cardHolderError.textContent = event.error;
            } else {
                cardHolderError.textContent = "";
            }
        });

        /**
         * Create card number input
         */
        const cardNumber = mollie.createComponent("cardNumber");
        cardNumber.mount("#card-number");

        const cardNumberError = document.getElementById("card-number-error");

        cardNumber.addEventListener("change", event => {
            if (event.error && event.touched) {
                cardNumberError.textContent = event.error;
            } else {
                cardNumberError.textContent = "";
            }
        });

        /**
         * Create expiry date input
         */
        const expiryDate = mollie.createComponent("expiryDate");
        expiryDate.mount("#expiry-date");

        const expiryDateError = document.getElementById("expiry-date-error");

        expiryDate.addEventListener("change", event => {
            if (event.error && event.touched) {
                expiryDateError.textContent = event.error;
            } else {
                expiryDateError.textContent = "";
            }
        });

        /**
         * Create verification code input
         */
        const verificationCode = mollie.createComponent("verificationCode");
        verificationCode.mount("#verification-code");

        const verificationCodeError = document.getElementById("verification-code-error");

        verificationCode.addEventListener("change", event => {
            if (event.error && event.touched) {
                verificationCodeError.textContent = event.error;
            } else {
                verificationCodeError.textContent = "";
            }
        });


        /**
         * For the floating labels to work we need some extra event listeners
         * to set proper classes on the form-group elements: `has-focus` and `is-dirty`
         */

        function toggleFieldDirtyClass(fieldName, dirty) {
            const element = document.getElementById(fieldName);
            element.parentNode.classList.toggle('is-dirty', dirty);
        }

        function toggleFieldFocusClass(fieldName, hasFocus) {
            const element = document.getElementById(fieldName);
            element.parentNode.classList.toggle('has-focus', hasFocus);
        }

        cardHolder.addEventListener("change", event => toggleFieldDirtyClass('card-holder', event.dirty));
        cardHolder.addEventListener("focus", () => toggleFieldFocusClass('card-holder', true));
        cardHolder.addEventListener("blur", () => toggleFieldFocusClass('card-holder', false));

        cardNumber.addEventListener("change", event => toggleFieldDirtyClass('card-number', event.dirty));
        cardNumber.addEventListener("focus", () => toggleFieldFocusClass('card-number', true));
        cardNumber.addEventListener("blur", () => toggleFieldFocusClass('card-number', false));

        expiryDate.addEventListener("change", event => toggleFieldDirtyClass('expiry-date', event.dirty));
        expiryDate.addEventListener("focus", () => toggleFieldFocusClass('expiry-date', true));
        expiryDate.addEventListener("blur", () => toggleFieldFocusClass('expiry-date', false));

        verificationCode.addEventListener("change", event => toggleFieldDirtyClass('verification-code', event.dirty));
        verificationCode.addEventListener("focus", () => toggleFieldFocusClass('verification-code', true));
        verificationCode.addEventListener("blur", () => toggleFieldFocusClass('verification-code', false));

        checkoutForm.addEventListener('submit', async event => {
            if (isCreditCardMethod()) {
                event.preventDefault();
                const { token, error } = await mollie.createToken();
                if (error) {
                    return;
                }

                let data = {"card_token": token};
                MollieHttpClient.http.post('/shop.php?do=MollieCardToken', data);

                checkoutForm.submit();
            }
        });

        function isCreditCardMethod()
        {
            let selectedMethod =  document.querySelector('input[name=payment]:checked').value;

            return selectedMethod === 'mollie_creditcard';
        }
    });
})();