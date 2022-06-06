window.onload = validateCategoryForm();
window.onload = validateCategoryForm2();


function validateCategoryForm() {

    console.log(expenses);
    console.log(incomes);


    $(document).ready(function () {
        $('#formCategory').validate({
            errorElement: 'li',
            rules: {
                newCategoryName: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    remote: '/account/validate-category'


                }
            },
            messages: {
                newCategoryName: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',
                    remote: 'Name already exists.'
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'newCategoryName') {
                    error.appendTo('.categoryNameError');
                }

            }

        });
    });
}

function validateCategoryForm2() {

    console.log(expenses);
    console.log(incomes);


    $(document).ready(function () {
        $('#formCategory2').validate({
            errorElement: 'li',
            rules: {
                newCategoryName: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    remote: '/account/validate-category'


                }
            },
            messages: {
                newCategoryName: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',
                    remote: 'Name already exists.'
                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'newCategoryName') {
                    error.appendTo('.categoryNameError2');
                }

            }

        });
    });
}
