async function showLimit(limit) {
    const windowWithInformation = document.querySelector('#showLimit');
    let nameOfCategory = document.querySelectorAll('.categorySelect');

    if (limit !== "0.00") {

        let sumOfExpense = getSumOfExpenseOfCategory();
        console.log(sumOfExpense);

        sumOfExpense.then((value) => {


            let expense;

            if (value != null) {
                expense = value;

            }
            else {
                expense = 0;

            }

            showLimitInformation(limit, expense, nameOfCategory);

        })



    } else {

        windowWithInformation.classList.add('d-none');
    }


}


async function getTotalExpense(sum) {

    console.log(sum);
    return sum
}

const getSumOfExpenseOfCategory = async () => {

    let categoryName = document.querySelector('.categorySelect').value;

    const firstDay = getFirstDayOfSelectedPeriod();
    const lastDay = getLastDayOfSelectedPeriod();
    console.log(firstDay);
    console.log(lastDay);

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

    for (let i = 0; i < data2.length; i++) {
        if (categoryName == data2[i].name) {

            categoryName = data2[i].name;
            console.log(categoryName);

            sumOfExpense = data2[i].sum;
            console.log(sumOfExpense);

            getTotalExpense(sumOfExpense);
            console.log(sumOfExpense);
            return sumOfExpense;

        }

    }



}

const getChoosenDateFromInput = () => {
    let dateChooseByUser = document.getElementById('date').value;

    let day = dateChooseByUser.slice(8);
    let month = dateChooseByUser.slice(6, 7);
    let year = dateChooseByUser.slice(0, 4);

    let date2 = new Date(year, month - 1, day);

    return date2;
}

const getFirstDayOfSelectedPeriod = () => {

    let dateFromInput = getChoosenDateFromInput();
    dateFromInput.setDate(2);
    const firstDay = dateFromInput.toISOString().slice(0, 10);
    return firstDay;
}


const getLastDayOfSelectedPeriod = () => {
    let dateFromInput = getChoosenDateFromInput();
    dateFromInput.setDate(2);
    dateFromInput.setMonth(dateFromInput.getMonth() + 1, 1);
    const lastDay = dateFromInput.toISOString().slice(0, 10);
    return lastDay;

}


const showLimitInformation = (limit, sumOfExpense, nameOfCategory) => {
    const windowWithInformation = document.querySelector('#showLimit');
    windowWithInformation.classList.remove('d-none');
    changeWindowWithInformationAboutLimitColor(limit, sumOfExpense);
    displayNameInWindow(nameOfCategory);
    displayLimitInWindow(limit);
    displaySumOfExpenseInWindow(sumOfExpense);
    displayDifferrenceInWindow(limit, sumOfExpense);
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

            limitOfCategory = data[i].categoryLimit;
            console.log(limitOfCategory);

            showLimit(limitOfCategory);

        }

    }

}


const selectCategoryOption = document.querySelectorAll('#exampleDataList');
for (let option of selectCategoryOption) {
    option.addEventListener('change', showLimitForSelectedCategory)
}


//display limit in box
const displayLimitInWindow = (limit) => {
    const categoryLimit = document.querySelector('#categoryLimit');
    categoryLimit.textContent = limit;
}

//display name of category in box
const displayNameInWindow = (nameOfCategory) => {
    const categoryName = document.querySelector('#categoryName');
    let categoryValue = document.querySelector('.categorySelect').value;
    categoryName.textContent = categoryValue;
}

const displaySumOfExpenseInWindow = (sumOfExpense) => {
    const categorySpent = document.querySelector('#categorySpent');
    if (sumOfExpense != null) { categorySpent.textContent = sumOfExpense }
    else { categorySpent.textContent = "0.00" }
}


const displayDifferrenceInWindow = (limit, sumOfExpense) => {
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

/*
const displayDifferrenceInWindow = (limit, sumOfExpense) => {
    let difference = limit - sumOfExpense;
    if (difference >= 0) {
        difference.assignRemaindedAmount();
    } else {
        difference.assignExceededAmount();
    }
}



Number.prototype.assignRemaindedAmount = function () {
    const categoryRemainded = document.querySelector('#amountOfRemained')
    const headingRemainded = document.querySelector('#headerOfRemained');
    headingRemainded.textContent = "Remained: ";
    categoryRemainded.textContent = this.toFixed(2);
}

Number.prototype.assignExceededAmount = function () {
    const categoryRemainded = document.querySelector('#amountOfRemained')
    const headingRemainded = document.querySelector('#headerOfRemained');
    headingRemainded.textContent = "Exceeded: ";
    categoryRemainded.textContent = Math.abs(this).toFixed(2);
}

*/
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


const showLimitAfterChangeDate = () => {
    let categoryValue = document.querySelector('.categorySelect').value;
    if (categoryValue) {
        showLimitForSelectedCategory();

    }
}


//showLimitAfterChangeDate
chooseDate = document.getElementById('date');
chooseDate.addEventListener('change', showLimitAfterChangeDate);


