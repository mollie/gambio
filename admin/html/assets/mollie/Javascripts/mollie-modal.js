var Mollie = window.Mollie || {};

(function (node, offset) {
    function ModalOpenerService() {
        this.openModal = openModal;
        this.createCancelButton = createCancelButton;
        this.createActionButton = createActionButton;

        /**
         *
         * @param {string} serverUrl
         * @param {object} specificConfig
         */
        function openModal(serverUrl, specificConfig) {
            let modalContent = $('.mollie-modal-content');
            modalContent.empty().addClass('mollie-loading');

            let modal = $('.mollie-modal');
            let requiredConfig = getRequiredConfig();
            let defaultConfig = getDefaultConfig();
            let configuration = $.extend(defaultConfig, specificConfig);
            configuration = $.extend(configuration, requiredConfig);

            modal.dialog(configuration);
            modal.dialog('open');
            modalContent.load(serverUrl, function () {
                modalContent.removeClass('mollie-loading');
                configuration.onLoad();
            });
        }

        /**
         *
         * @returns {{autoOpen: boolean, modal: boolean}}
         */
        function getRequiredConfig() {
            return {
                autoOpen: false,
                modal: true,
            };
        }

        /**
         *
         * @returns {{minHeight: number, buttons: {text: *, class: string, click: click}, maxHeight: number, minWidth: number, dialogClass: string, title: string, maxWidth: number}}
         */
        function getDefaultConfig() {
            return {
                'title': '',
                'dialogClass': 'gx-container',
                buttons: createCancelButton(),
                minWidth: 510,
                maxWidth: 900,
                minHeight: 350,
                maxHeight: 650,
                onLoad: function () {}
            };
        }

        /**
         *
         * @returns {{text: *, class: string, click: click}}
         */
        function createCancelButton() {
            return {
                'text': jse.core.lang.translate('close', 'buttons'),
                'class': 'btn',
                'click': function click() {
                    $(this).dialog('close');
                }
            }
        }

        /**
         *
         * @param {string} id
         * @param {string} label
         * @returns {{id: *, text: *, class: string, click: click}}
         */
        function createActionButton(id, label) {
            return {
                'id': id,
                'text': label,
                'class': 'btn btn-primary mollie-dialog-submit',
                'click': function () {
                    $(this).dialog('close');
                }
            }
        }
    }

    Mollie.modal = new ModalOpenerService();
})();
