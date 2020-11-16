(function() {
    document.addEventListener("DOMContentLoaded", function () {
        if (window.ApplePaySession && window.ApplePaySession.canMakePayments()) {
            let applepay = document.querySelector('.mollie_applepay');
            if (applepay) {
                applepay.style.display = 'block';
            }
        }
    });
})();