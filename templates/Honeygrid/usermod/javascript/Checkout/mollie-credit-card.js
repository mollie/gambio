(function() {
    document.addEventListener("DOMContentLoaded", function () {

        let cardWrapper = document.querySelector('.mollie-component-wrapper');
        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let creditCardComponents = document.querySelector('.mollie-component-wrapper');

        if (isCreditCardMethod()) {
            creditCardComponents.classList.remove('mollie-hidden');
            setTimeout(mountIfActive, 100);
        }

        for (let i = 0; i < paymentMethods.length; i++) {
            paymentMethods[i].onchange =  function (event) {

                let target = event.target;
                if (target.value === 'mollie_creditcard') {
                    creditCardComponents.classList.remove('mollie-hidden');
                    setTimeout(mountIfActive, 100);
                } else {
                    creditCardComponents.classList.add('mollie-hidden');
                    MollieComponents.creditCard.unmount();
                }
            }
        }

        function isCreditCardMethod()
        {
            let selectedMethod = document.querySelector('input[name=payment]:checked');
            if (selectedMethod) {
                return selectedMethod.value === 'mollie_creditcard';
            }

            selectedMethod = document.querySelector('input[name=payment]');
            if (selectedMethod.type === 'hidden') {
                return selectedMethod.value === 'mollie_creditcard';
            }

            return false;
        }

        function mountIfActive() {
            let creditCardWrapper = document.querySelector('.mollie_creditcard');
            let isActive = creditCardWrapper.classList.contains('active') || isCreditCardOnlyPayment();
            if (creditCardWrapper && isActive) {
                MollieComponents.creditCard.mount(cardWrapper);
            }
        }

        function isCreditCardOnlyPayment() {
            return paymentMethods.length === 1 && paymentMethods[0].classList.contains('mollie_creditcard');
        }

    });
})();