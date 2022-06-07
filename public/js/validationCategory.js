window.onload = validateCategoryForm();
window.onload = validateCategoryForm2();



$.validator.addMethod('validCategoryName',
    function (value, element, param) {


        let categoryNameToEdit = document.querySelector('input[name="newCategoryName"]');
        let categoryNameToAdd = document.querySelector('input[name="newCategoryName2"]');

        for (let i = 0; i < incomes.length; i++) {
            if ((incomes[i].name == categoryNameToEdit.value) || (incomes[i].name == categoryNameToAdd.value)) {
                console.log('Exists!');
                return false;
            }

        }
        return true;
    },
    "Name of category already taken! Please enter a different name."
);

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
                    validCategoryName: true

                }
            },
            messages: {
                newCategoryName: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',

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
                newCategoryName2: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    validCategoryName: true
                }
            },
            messages: {
                newCategoryName2: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',

                }
            },
            errorPlacement: function (error, element) {

                if (element.attr('name') == 'newCategoryName2') {
                    error.appendTo('.categoryNameError2');
                }

            }

        });
    });
}
