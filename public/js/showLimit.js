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


const getExpenseForCategory = async () => {

    let dateChooseByUser = document.getElementById('date').value;

    let day = dateChooseByUser.slice(8);
    let month = dateChooseByUser.slice(6, 7);
    let year = dateChooseByUser.slice(0, 4);



    let date2 = new Date(year, month - 1, day);



    date2.setDate(2);

    const firstDay = date2.toISOString().slice(0, 10);
    date2.setMonth(date2.getMonth() + 1, 1);
    const lastDay = date2.toISOString().slice(0, 10);




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



    let response = await fetch('/Expense/getExpenses', options);
    const data2 = await response.json();

    console.log(data2);

    if (data2.length > 0) {
        for (let i = 0; i < data2.length; i++) {
            if (categoryName.value == data2[i].name) {

                expenseAssignedToCategory = data2[i].sum;

            }

        }
    } else {
        expenseAssignedToCategory = 0;

    }
    return expenseAssignedToCategory;

}


const showBoxInformationAboutLimit = () => {
    const windowWithInformation = document.querySelector('#showLimit');


    let limitOfCategory = getLimitForCategory();

    let expenseOfCategory = getExpenseForCategory();

    let limit;
    let expense;

    limitOfCategory.then((value) => {
        if (value !== '0.00') {

            windowWithInformation.classList.remove('d-none');
            limit = value;



            expenseOfCategory.then((value2) => {

                let expense = value2;

                changeWindowWithInformationAboutLimitColor(limit, expense);
                showName();
                showLimit(limit);
                showSum(expense);
                showDifference(limit, expense);



            })

        } else {
            windowWithInformation.classList.add('d-none');

        }

    });
}



const showLimitAfterChangeDate = () => {
    let categoryValue = document.querySelector('.categorySelect').value;
    if (categoryValue) {
        showBoxInformationAboutLimit();

    }
}


//show Limit Information if it is assigned to a category
categoryName.addEventListener('change', showBoxInformationAboutLimit);

//showLimitAfterChangeDate
chooseDate = document.getElementById('date');
chooseDate.addEventListener('change', showLimitAfterChangeDate);



//display limit in box
const showLimit = (limit) => {
    const categoryLimit = document.querySelector('#categoryLimit');
    categoryLimit.textContent = limit;
}

//display name of category in box
const showName = () => {
    const categoryName = document.querySelector('#categoryName');
    let categoryValue = document.querySelector('.categorySelect').value;
    categoryName.textContent = categoryValue;
}

const showSum = (sumOfExpense) => {
    const categorySpent = document.querySelector('#categorySpent');
    if (sumOfExpense != undefined) { categorySpent.textContent = sumOfExpense }
    else { categorySpent.textContent = 0 }
}


const showDifference = (limit, sumOfExpense) => {
    const categoryRemainded = document.querySelector('#amountOfRemained')
    const headingRemainded = document.querySelector('#headerOfRemained');
    let difference = limit - sumOfExpense;
    if (difference >= 0) {
        headingRemainded.textContent = "Remained: ";
        categoryRemainded.textContent = difference.toFixed(2);
    } else {
        headingRemainded.textContent = "Exceeded: ";
        categoryRemainded.textContent = difference.toFixed(2);
    }
}



const changeWindowWithInformationAboutLimitColor = (limit, sumOfExpense) => {
    const windowWithInformationsAboutLimit = document.querySelector('#showLimit');
    let difference = limit - sumOfExpense;
    if (difference >= 0) {
        windowWithInformationsAboutLimit.classList.remove('bg-danger');
        windowWithInformationsAboutLimit.classList.add('bg-success');
    }
    else {
        windowWithInformationsAboutLimit.classList.remove('bg-success');
        windowWithInformationsAboutLimit.classList.add('bg-danger');
    }
}



