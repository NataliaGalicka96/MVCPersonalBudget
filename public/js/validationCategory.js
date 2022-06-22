window.onload = validateCategoryForm();
window.onload = validateCategoryForm2();




$.validator.addMethod('validCategoryName',
    function (value, element, param) {


        let categoryNameToEdit = document.querySelector('input[name="newCategoryName"]');
        let categoryNameToAdd = document.querySelector('input[name="newCategoryName2"]');

        if (incomes) {
            for (let i = 0; i < incomes.length; i++) {
                if (((incomes[i].name).toLowerCase() == (categoryNameToEdit.value).toLowerCase()) || ((incomes[i].name).toLowerCase() == (categoryNameToAdd.value).toLowerCase())) {

                    return false;
                }

            }
            return true;
        }

        if (expenses) {
            for (let i = 0; i < expenses.length; i++) {
                if (((expenses[i].name).toLowerCase() == (categoryNameToEdit.value).toLowerCase()) || ((expenses[i].name).toLowerCase() == (categoryNameToAdd.value).toLowerCase())) {

                    return false;
                }

            }
            return true;

        }

        if (payment) {
            for (let i = 0; i < payment.length; i++) {
                if (((payment[i].name).toLowerCase() == (categoryNameToEdit.value).toLowerCase()) || ((payment[i].name).toLowerCase() == (categoryNameToAdd.value).toLowerCase())) {
                    return false;
                }

            }
            return true;

        }

    },
    "Name of category already taken! Please enter a different name."
);

function validateCategoryForm() {


    $(document).ready(function () {
        $('#formCategory').validate({
            errorElement: 'li',
            rules: {
                newCategoryName: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    validCategoryName: true

                },
                categoryLimit: {

                    number: true,
                    min: 0,
                    max: 9999.99,
                    step: 0.01

                }
            },
            messages: {
                newCategoryName: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',

                },
                categoryLimit: {

                    min: 'The amount quoted must be between 0 and 1 thousand.',
                    max: 'The amount quoted must be between 0 and 1 thousand.'
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'newCategoryName') {
                    error.appendTo('.categoryNameError');
                }
                if (element.attr('name') == 'categoryLimit') {
                    error.appendTo('.limitError');
                }

            }

        });
    });
}

function validateCategoryForm2() {


    $(document).ready(function () {
        $('#formCategory2').validate({
            errorElement: 'li',
            rules: {
                newCategoryName2: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    validCategoryName: true
                },
                categoryLimit2: {

                    number: true,
                    min: 0,
                    max: 9999.99,
                    step: 0.01

                }
            },
            messages: {
                newCategoryName2: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',

                },
                categoryLimit2: {

                    min: 'The amount quoted must be between 0 and 1 thousand.',
                    max: 'The amount quoted must be between 0 and 1 thousand.'
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'newCategoryName2') {
                    error.appendTo('.categoryNameError2');
                }
                if (element.attr('name') == 'categoryLimit2') {
                    error.appendTo('.limitError2');
                }

            }

        });
    });
}
