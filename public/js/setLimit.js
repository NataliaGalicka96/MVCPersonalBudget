function showInputToSetLimit() {
    let checkbox = document.getElementById('defaultCheck1');
    let divLimit = document.getElementById('limit');


    if (checkbox.checked == true) {
        divLimit.style.visibility = 'visible';
    } else {
        divLimit.style.visibility = 'hidden';
    }

}

function showInputToSetLimit2() {
    let checkbox = document.getElementById('defaultCheck2');
    let divLimit = document.getElementById('limit2');


    if (checkbox.checked == true) {
        divLimit.style.visibility = 'visible';
    } else {
        divLimit.style.visibility = 'hidden';
    }

}


window.onload = manageModal();
function manageModal() {

    $(document).on('click', '#editButton', function () {

        $('#editCategoryName input[name="newCategoryName"]').val($(this).attr('data-bs-category-name'));
        $('#editCategoryName input[name="categoryOldId"]').val($(this).attr('data-bs-category-id'));
        $('#deleteCategory input[name="categoryOldId"]').val($(this).attr('data-bs-category-id'));
        let categoryName = $(this).attr('data-bs-category-name');
        console.log(categoryName);

        showLimitForSelectedCategory(categoryName);
    });


}


async function showLimit(limit, categoryName) {
    let limitInput = document.querySelector('#categoryLimit');
    if (limit !== "0.00") {

        limitInput.placeholder = limit;

    } else {
        limitInput.placeholder = 0;

    }

}

const showLimitForSelectedCategory = async (categoryName) => {


    let response = await fetch('/api/expenses');
    const data = await response.json()

    console.log(data);

    for (let i = 0; i < data.length; i++) {
        if (categoryName == data[i].name) {

            limitOfCategory = data[i].categoryLimit;
            console.log(limitOfCategory);

            showLimit(limitOfCategory, categoryName);

        }

    }

}



