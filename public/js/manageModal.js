window.onload = manageModal();

function manageModal() {

    $(document).on('click', '#editButton', function () {

        $('#editCategoryName input[name="newCategoryName"]').val($(this).attr('data-category-name'));
        $('#editCategoryName input[name="categoryOldId"]').val($(this).attr('data-category-id'));
        $('#deleteCategory input[name="categoryOldId"]').val($(this).attr('data-category-id'));
        console.log($(this).attr('data-category-id'));

    });

    $(document).on('click', '#deleteButton', function () {

        $('#deleteCategory input[name="categoryOldId"]').val($(this).attr('data-category-id'));
        console.log($(this).attr('data-category-id'));

    });
}