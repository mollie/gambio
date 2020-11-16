$(document).ready(function () {
    let submitButton = $('#mollie-config-save');

    submitButton.click(function () {
        $('#mollie-config-form').submit();
    })

    var bottomElement = $('.bottom-save-bar');

    _moveButtons();

    /**
     * Move action buttons to the footer
     *
     * @private
     */
    function _moveButtons() {
        $('.bottom-save-bar-content > *:not([type="hidden"]):not(.btn-primary)').each(function (index, element) {
            var $element = $(element).css('float', 'none');
            _handleContentType($element);
        });

        $('.bottom-save-bar-content > *.btn-primary:not([type="hidden"])').each(function (index, element) {
            var $element = $(element).css('float', 'none');
            _handleContentType($element);
        });
    }

    function _handleContentType($element) {
        if ($element.is('input:not([type="button"])') || $element.is('button[type="submit"]')) {
            _handleFormElement($element);
        } else {
            _handleOtherContent($element);
        }
    }

    function _handleFormElement($element) {
        var $clone = $element.clone();
        $element.hide();

        if ($element.is('[type="submit"]')) {
            $clone.attr('type', 'button');
        }

        $clone.on('click', function () {
            $element.trigger('click');
        });

        bottomElement.append($clone);
    }

    function _handleOtherContent($element) {
        bottomElement.append($element);
    }
});
