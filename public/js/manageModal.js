window.onload = manageModal();

function manageModal() {

    $(document).on('click', '#editButton', function () {

        $('#editCategoryName input[name="newCategoryName"]').val($(this).attr('data-bs-category-name'));
        $('#editCategoryName input[name="categoryOldId"]').val($(this).attr('data-bs-category-id'));
        $('#deleteCategory input[name="categoryOldId"]').val($(this).attr('data-bs-category-id'));
        console.log($(this).attr('data-bs-category-id'));

    });

    $(document).on('click', '#deleteButton', function () {

        $('#deleteCategory input[name="categoryOldId"]').val($(this).attr('data-bs-category-id'));
        console.log($(this).attr('data-bs-category-id'));

    });
}