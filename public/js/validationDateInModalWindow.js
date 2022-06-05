window.onload = validateDataForm();


function validateDataForm() {

    /**
     * Add jQuery Validation plugin method for a valid date
     *
     * Validate date must be between 2000-01-01 and last day of current month
     */

    $.validator.addMethod('validDate',
        function (value, element, param) {

            if (value < '2000-01-01' || value > lastDayOfCurrentMonth) {
                return false;
            }
            return true;
        },
        "Date must be between 2000-01-01 and " + lastDayOfCurrentMonth + "."
    );


    $(document).ready(function () {
        $('#DateForm').validate({
            errorElement: 'p',
            rules: {

                date1: {
                    required: true,
                    date: true,
                    validDate: true

                },
                date2: {
                    required: true,
                    date: true,
                    validDate: true

                }
            },
            messages: {

                date1: {
                    required: 'Date1 is required.'
                },
                date2: {
                    required: 'Date2 is required.'
                },

            },

            errorPlacement: function (error, element) {


                if (element.attr('name') == 'date1') {
                    error.appendTo('#dateError');
                }
                if (element.attr('name') == 'date2') {
                    error.appendTo('#dateError');
                }

            }

        });

        $('#data2').validate({
            errorElement: 'p',
            rules: {

                date: {
                    required: true,
                    date: true,
                    validDate: true

                }
            },
            messages: {

                date: {
                    required: 'Date is required.'
                },

            },

            errorPlacement: function (error, element) {


                if (element.attr('name') == 'date') {
                    error.appendTo('#dateError');
                }

            }

        });
    });
}
