window.onload = validateDataForm();


function validateDataForm() {

    $(document).ready(function () {
        $('#data').validate({
            errorElement: 'p',
            rules: {
                amount: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 999999.99,
                    step: 0.01
                },
                date: {
                    required: true,
                    date: true,

                },
                category: {
                    required: true
                },
                payment: {
                    required: true
                },
                comment: {
                    maxlength: 100
                }
            },
            messages: {
                amount: {
                    required: 'Amount is required.',
                    min: 'The amount quoted must be between 0 and 1 million.',
                    max: 'The amount quoted must be between 0 and 1 million.'
                },
                date: {
                    required: 'Date is required.'
                },
                category: {
                    required: 'Category is required.'
                },
                payment: {
                    required: 'Payment method is required.'
                },
            },

            errorPlacement: function (error, element) {

                if (element.attr('name') == 'amount') {
                    error.appendTo('#amountError');
                }
                if (element.attr('name') == 'date') {
                    error.appendTo('#dateError');
                }
                if (element.attr('name') == 'category') {
                    error.appendTo('#categoryError');
                }
                if (element.attr('name') == 'comment') {
                    error.appendTo('#commentError');
                }
                if (element.attr('name') == 'payment') {
                    error.appendTo('#paymentError');
                }
            }

        });
    });
}
