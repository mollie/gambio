(function() {
    document.addEventListener("DOMContentLoaded", function () {

        let cards = document.querySelectorAll('.mollie-component-wrapper');
        cards.forEach(card => {
            MollieComponents.creditCard(card);
        });


        let paymentMethods = document.querySelectorAll('li.list-group-item');
        let creditCardComponents = document.querySelector('.mollie-component-wrapper');

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

        function isCreditCardMethod()
        {
            let selectedMethod = document.querySelector('input[name=payment]:checked');
            if (selectedMethod) {
                return selectedMethod.value === 'mollie_creditcard';
            }

            return false;
        }
    });
})();