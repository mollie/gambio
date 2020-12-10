(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let cards = document.querySelectorAll('.mollie-component-wrapper');
        cards.forEach(card => {
            MollieComponents.creditCard(card);
        });
    });
})();