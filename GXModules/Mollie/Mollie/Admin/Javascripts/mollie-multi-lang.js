$(document).ready(function () {
    $('.multi-lang-input').change(function () {
        let disabled = false;
        $('.multi-lang-input').each(function () {
            let errorClass = 'mollie-lang-input-error';
            if (!$(this).val()) {
                disabled = true;
                $(this).addClass(errorClass);
            } else {
                $(this).removeClass(errorClass);
            }
        });

        $('.main-bottom-footer').find('button.btn-primary').prop('disabled', disabled);
    })
});
