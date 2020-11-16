var Mollie = window.Mollie || {};

(function () {
    function CopyToClipboardService() {
        this.copy = copy;

        /**
         * Performs Copy to clipboard action of the text content of the provided element
         *
         * @param {string} text
         */
        function copy(text) {
            let textarea = document.createElement('textarea'),
                selection = document.getSelection(),
                range = document.createRange();

            textarea.textContent = text;
            document.body.appendChild(textarea);

            range.selectNode(textarea);
            selection.removeAllRanges();
            selection.addRange(range);

            document.execCommand('copy');
            selection.removeAllRanges();

            document.body.removeChild(textarea);
        }


    }

    Mollie.copyToClipboard = new CopyToClipboardService();
})();
