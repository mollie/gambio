(function() {
    document.addEventListener("DOMContentLoaded", function () {
        let issuerListWrappers = document.querySelectorAll('.mollie-issuer-list-wrapper');
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
    });
})();