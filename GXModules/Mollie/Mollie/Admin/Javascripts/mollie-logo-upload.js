$(document).ready(function () {
    let errorMessage = $('.mollie-logo-upload-error');
    $('#mollie-logo-upload-button').change(function () {
        let formData = new FormData();
        let url = $('#mollie-logo-endpoint').val();

        // Check file selected or not
        if(this.files && this.files[0]){
            formData.append('uploadFile',this.files[0]);

            $.ajax({
                url: url,
                type: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.is_uploaded) {
                        $("#mollie-preview-logo").attr("src", response.image_src);
                        $("#mollie-logo-form-field").val(response.image_src);
                        errorMessage.addClass('mollie-hidden')
                    } else {
                        errorMessage.removeClass('mollie-hidden');
                    }
                },
            });
        }
    })
});
