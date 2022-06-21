const getLimitWithId = async (categoryId) => {
    let response = await fetch(`/api/getLimitWithId/${categoryId}`);
    const data = await response.json()
    //return response.data.categoryLimit;
}



async function showLimitWithId(categoryId) {
    let limitCategory = await getLimitWithId(categoryId);
    if (limitCategory) {
        console.log(limitCategory);
        console.log('Tak jest limit dla tej kategorii')
    } else {
        console.log("Nie ma limitu dla tek kategorii")
    }

}






const showLimitForSelectedCategory = async () => {
    console.log('Limit');
    let categoryName = document.querySelector('.categorySelect').value;
    console.log(categoryName);
    let categoryId;

    let response = await fetch('/api/expenses');
    const data = await response.json()

    console.log(data);

    for (let i = 0; i < data.length; i++) {
        if (categoryName == data[i].name) {

            categoryId = data[i].id;
            console.log(typeof (categoryId));
            console.log(categoryId);

            showLimitWithId(categoryId);
        }

    }

}


const selectCategoryOption = document.querySelectorAll('#exampleDataList');
for (let option of selectCategoryOption) {
    option.addEventListener('change', showLimitForSelectedCategory)
}




