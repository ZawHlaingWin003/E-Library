

$(document).ready(function () {
    // Submit NewsLetter Subscribe Form
    $(document).on('submit', '#subscribe-form', function (e) {
        e.preventDefault();

        let url = $(this).attr('action');
        var _token = $("input[name='_token']").val();
        var email = $("#email").val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: _token,
                email: email
            },
            dataType: "json",
            beforeSend: function () {
                $('.error').text('');
                $("#subscribe-button-loader").removeClass('d-none').addClass('d-block');
                $("#subscribe-button-icon").removeClass('d-block').addClass('d-none');
                $("#subscribe-button").attr('disabled', true).css('cursor', 'wait');
            },
            success: function (data) {
                if (data.code == 200) {
                    let success = `<p class="alert alert-success">${data.response}</p>`;
                    $("#email-input-group").before(success);
                    $("#subscribe-form")[0].reset();

                } else if (data.code == 400) {
                    $.each(data.response, function (key, value) {
                        $("." + key + "-error").text(value);
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr, status, error)
                if (xhr.status == 401) {
                    Command: toastr["error"]("Unauthorized. Please Login First")
                }
            },
            complete: function (response) {
                $('#subscribe-button-loader').removeClass('d-block').addClass('d-none')
                $("#subscribe-button-icon").removeClass('d-none').addClass('d-block');
                $("#subscribe-button").attr('disabled', false).css('cursor', 'pointer');
            }
        });
    })
})