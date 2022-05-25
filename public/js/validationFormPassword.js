
window.onload = validatePasswordForm();


function validatePasswordForm() {



    /**
     * Add jQuery Validation plugin method for a valid password
     *
     * Valid passwords contain at least one letter and one number.
     */
    $.validator.addMethod('validPassword',
        function (value, element, param) {

            if (value != '') {
                if (value.match(/.*[a-z]+.*/i) == null) {
                    return false;
                }
                if (value.match(/.*\d+.*/) == null) {
                    return false;
                }
            }

            return true;
        },
        'Password must contain at least one letter and one number'
    );


    $(document).ready(function () {

        /**
         * Validate the form
         */
        $('#formPassword').validate({
            rules: {

                password: {
                    required: true,
                    minlength: 6,
                    validPassword: true
                }

            }
        });

    });

}
