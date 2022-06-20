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


fetch('/api/expenses')
    .then((response) => response.json())
    .then((data) => console.log(data));


fetch('/api/getLimit')
    .then((response) => response.json())
    .then((data) => console.log(data));




let categoryName = document.querySelector('.categorySelect');

let limitAssignedToCategory;
let expenseAssignedToCategory;


const getLimitForCategory = async () => {
    let response = await fetch('/api/getLimit');
    const data = await response.json();

    for (let i = 0; i < data.length; i++) {
        if (categoryName.value == data[i].name) {

            limitAssignedToCategory = data[i].categoryLimit;

        }

    }
    return limitAssignedToCategory;
}

//proba inaczej
const getExpenseForCategory = async () => {

    let dateChooseByUser = document.getElementById('date').value;

    let day = dateChooseByUser.slice(8);
    let month = dateChooseByUser.slice(6, 7);
    let year = dateChooseByUser.slice(0, 4);

    //console.log(day);
    //console.log(month);
    //console.log(year);

    let date2 = new Date(year, month - 1, day);

    //console.log(date2);

    date2.setDate(2);

    const firstDay = date2.toISOString().slice(0, 10);
    date2.setMonth(date2.getMonth() + 1, 1);
    const lastDay = date2.toISOString().slice(0, 10);

    //console.log(firstDay);
    //console.log(lastDay);


    let data = {
        start: firstDay,
        end: lastDay
    };

    const options = {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    };

    //const categorySpent = document.querySelector('#category-spent');

    let response = await fetch('/Expense/getExpenses', options);
    const data2 = await response.json();

    console.log(data2);

    // if (data2.length > 0) {
    for (let i = 0; i < data2.length; i++) {
        if (categoryName.value == data2[i].name) {

            expenseAssignedToCategory = data2[i].sum;
            //categorySpent.textContent = expenseAssignedToCategory;
        }

    }

    // } else {
    // expenseAssignedToCategory = 0;
    // categorySpent.textContent = expenseAssignedToCategory;
    //  }
    return expenseAssignedToCategory;

}





const getExpensesInCurrentMonth = () => {


    let dateChooseByUser = document.getElementById('date').value;

    let day = dateChooseByUser.slice(8);
    let month = dateChooseByUser.slice(6, 7);
    let year = dateChooseByUser.slice(0, 4);

    //console.log(day);
    //console.log(month);
    //console.log(year);

    let date2 = new Date(year, month - 1, day);

    //console.log(date2);

    date2.setDate(2);

    const firstDay = date2.toISOString().slice(0, 10);
    date2.setMonth(date2.getMonth() + 1, 1);
    const lastDay = date2.toISOString().slice(0, 10);

    //console.log(firstDay);
    //console.log(lastDay);


    let data = {
        start: firstDay,
        end: lastDay
    };

    const options = {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    };

    const categorySpent = document.querySelector('#category-spent');

    fetch('/Expense/getExpenses', options)
        .then((response) => response.json())
        .then((data => {
            console.log(data);

            if (data.length > 0) {


                for (let i = 0; i < data.length; i++) {
                    if (categoryName.value == data[i].name) {

                        expenseAssignedToCategory = data[i].sum;
                        console.log(expenseAssignedToCategory);
                        categorySpent.textContent = expenseAssignedToCategory;

                    }
                }
            } else {
                categorySpent.textContent = 0;
            }

        }));

}




const showBoxInformationAboutLimit = () => {
    const windowWithInformation = document.querySelector('#showLimit');
    const categorySpent = document.querySelector('#category-spent');

    let limitOfCategory = getLimitForCategory();

    ///proba nowe
    let expenseOfCategory = getExpenseForCategory();

    let limit;
    let expense;

    limitOfCategory.then((value) => {
        if (value !== '0.00') {

            windowWithInformation.classList.remove('d-none');
            limit = value;
            console.log(limit);

            //pobieram dane o wydatkach (mam tablice z wydatkami i sumą)

            expenseOfCategory.then((value2) => {

                let expense = value2;
                console.log(expense);


                changeWindowWithInformationAboutLimitColor(limit, expense);

                assignName();
                assignLimit(limit);
                assignSum(expense);
                assignDifference(limit, expense);



            })

        } else {
            windowWithInformation.classList.add('d-none');

        }

    })
}



const showLimitInformation = () => {
    showBoxInformationAboutLimit();

}


const showLimitAfterChangeDate = () => {
    let categoryValue = document.querySelector('.categorySelect').value;
    if (categoryValue) {
        showLimitInformation();

    }
}


//show Limit Information if it is assigned to a category
categoryName.addEventListener('change', showLimitInformation);

//showLimitAfterChangeDate
chooseDate = document.getElementById('date');
chooseDate.addEventListener('change', showLimitAfterChangeDate);



//display limit in box
const assignLimit = (limit) => {
    const categoryLimit = document.querySelector('#category-limit');
    categoryLimit.textContent = limit;
}

//display name of category in box
const assignName = () => {
    const categoryName = document.querySelector('#category-name');
    let categoryValue = document.querySelector('.categorySelect').value;
    categoryName.textContent = categoryValue;
}

const assignSum = (sum) => {
    const categorySpent = document.querySelector('#category-spent');
    if (sum != undefined) { categorySpent.textContent = sum }
    else { categorySpent.textContent = 0 }
}


const assignDifference = (limit, sum) => {
    let difference = limit - sum;
    if (difference >= 0) {
        difference.assignRemaindedAmount();
    } else {
        difference.assignExceededAmount();
    }
}



Number.prototype.assignRemaindedAmount = function () {
    const categoryRemainded = document.querySelector('#category-remainded')
    const headingRemainded = document.querySelector('#heading-remainded');
    headingRemainded.textContent = "Remaining: ";
    categoryRemainded.textContent = this.toFixed(2);
}

Number.prototype.assignExceededAmount = function () {
    const categoryRemainded = document.querySelector('#category-remainded')
    const headingRemainded = document.querySelector('#heading-remainded');
    headingRemainded.textContent = "Przekroczono: ";
    categoryRemainded.textContent = Math.abs(this).toFixed(2);
}

const changeWindowWithInformationAboutLimitColor = (limit, sum) => {
    let difference = limit - sum;
    if (difference >= 0) { changeColorToSuccess() }
    else { changeColorToDanger() }
}

const changeColorToSuccess = () => {
    const windowWithInformationsAboutLimit = document.querySelector('#showLimit');
    windowWithInformationsAboutLimit.classList.remove('bg-danger');
    windowWithInformationsAboutLimit.classList.add('bg-success');
}

const changeColorToDanger = () => {
    const windowWithInformationsAboutLimit = document.querySelector('#showLimit');
    windowWithInformationsAboutLimit.classList.remove('bg-success');
    windowWithInformationsAboutLimit.classList.add('bg-danger');
}