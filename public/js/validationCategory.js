window.onload = validateCategoryForm();


function validateCategoryForm() {

    console.log(expenses);
    console.log(incomes);


    /**
     * Check if this name already exists
     * 
     */

    $.validator.addMethod('validNameCategory',
        function (value, element, param) {

            let categoryNewName = document.getElementById(category);

            for (let i = 0; i < incomes.length; i++) {
                if (incomes[i].name == categoryNewName.value()) {
                    return false
                }
                return true;
            }



        },
        "Category already exists."
    );

    $(document).ready(function () {
        $('formCategory').validate({
            rules: {
                newCategoryName: {
                    required: true,
                    minlength: 3,
                    maxlength: 40,
                    validNameCategory: true,
                    /*remote: {
                        url: '/settings/validate-category',
                        type: "post",
                        data: {
                            categoryType: function () {
                                return $('input[name="categoryNewName"]').attr('data-bs-category-type');
                            },
                            categoryOldId: function () {
                                return $('input[name="categoryOldId"]').val();
                            }
                        }
                    }*/
                }
            },
            messages: {
                newCategoryName: {
                    required: 'Name of category is required.',
                    minlength: 'Name of category needs to be between 3 to 40 characters.',
                    maxlength: 'Name of category needs to be between 3 to 40 characters.',
                    //remote: 'Name already exists.'
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
