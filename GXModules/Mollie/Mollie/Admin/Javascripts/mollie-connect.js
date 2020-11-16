$(document).ready(function () {
    let verifyButton = $('#mollie-verify-button');
    let isTestMode = $('#mollie_test_mode');
    let liveToken = $('#mollie_live_token');
    let testToken = $('#mollie_test_token');
    let switcher = $('#mollie-config-form').find('.switcher');
    let testMode = testToken.is(':checked');



    verifyButton.click(function () {
        testMode = switcher.hasClass('checked');
        let data = {
            'is_test': isTestMode.is(':checked'),
            'live_token': liveToken.val(),
            'test_token': testToken.val(),
        };

        $.ajax({
            url: 'admin.php?do=MollieConnect',
            type: 'post',
            data: JSON.stringify(data),
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function () {
                location.reload();
            },
        });
    });
});
