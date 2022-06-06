
window.onload = validateEmailForm();

function validateEmailForm() {

    $(document).ready(function () {
        $('#formEmail').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    remote: '/account/validate-email'
                }
            },
            messages: {
                email: {
                    remote: 'Email already taken!'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('name') == 'email') {
                    error.appendTo('.emailError');
                }

            }
        });

    });

}
