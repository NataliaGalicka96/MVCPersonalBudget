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



//Wszystkie kategorie i limity do danej kategorii
let categoryName = document.getElementById('exampleDataList');
let monthlyLimit = document.getElementById('monthlyLimit');
let alreadySpent = document.getElementById('alreadySpent');
let remainingAmount = document.getElementById('remaining');

let categoryId;


async function getIdCategoryAssignedToUser() {
    let response = await fetch('/api/expenses');
    const data = await response.json();
    for (let i = 0; i < data.length; i++) {
        if (categoryName.value == data[i].name) {
            // monthlyLimit.textContent = `Monthly limit: ${data[i].categoryLimit}`;
            //console.log(data[i].categoryLimit);
            // console.log(data[i].name);
            // console.log(data[i].id)
            categoryId = data[i].id;
        }
    }

    return categoryId;
}


console.log(categoryId);

const getLimitWithId = async (categoryId) => {

    let response = await fetch(`/api/getLimitWithId/${categoryId}`);
    const data = await response.json();
    console.log(data);

    /*
    const data = await response.json();
    for (let i = 0; i < data.length; i++) {
        if (categoryName.value == data[i].name) {
            monthlyLimit.textContent = `Monthly limit: ${data[i].sum}`;
            console.log(data[i].categoryLimit);
            console.log(data[i].id)



        }
    }
    */
}





//Wydarzenie przy zmiane kategorii (zdarzenie onchange)
const checkCategory = () => {
    let id = getIdCategoryAssignedToUser();
    let idd;
    id.then((value) => {
        console.log(value);
        getLimitWithId(value);
    });

}



let categoryName3 = document.querySelector('.categorySelect');

categoryName3.addEventListener('change', checkCategory);








/*

const getLimitForCategory = async (categoryId) => {
    let response = await fetch(`/api/getLimit/:${categoryId}`);
    const data = await response.json();




    return data.categoryLimit;
}


*/








async function showLimit(categoryId) {
    let limitCategory = await getLimitForCategory(categoryId);
    if (limitCategory) {
        console.log(limitCategory);
    }
}


async function showLimitAfterChangeDate() {

}



//Funkcja sprawdza czy podana kategoria ma ustawiony limit
//jesli tak to zwraca wartosc tego limitu
//id zmienna dynamiczna w zalezności od kategorii

const getLimitForCategoryNAUKA = () => {
    fetch(`/api/limit/:${id}`);
};

//Pobieramy datę ustawioną (chodzi o miesiąc). 
//Zawołamy api które zwróci ile w tym miesiącu wydalismy już dla tej kategorii
//
const getSumOfExpensesForSelectedMonthNAUKA = () => {
    fetch(`/api/expenses/:${id}?date=${date}`);
};


const calculateLimits = () => {
    //calculate limits
}

//Zmiana daty wołamy do tego API, które jak zmieniamy datę to nam zwróci ile w takim miesiącu 
//wydaliśmy, wynik zapisujemy do zmiennej 
const checkLimitNAUKA = () => {
    getSumOfExpensesForSelectedMonth();
    calculateLimit();
    renderOnDOM();
}


fetch('/Expense/getExpenses')
    .then((response) => response.json())
    .then((data) => console.log(data));


/*
const getSumOfExpensesForSelectedMonth = () => {


    let dateChooseByUser = document.getElementById('date').value;

    //pierwszy dzień obecnego miesiąca
    console.log(firstDayOfCurrentMonth);

    //ostatni dzień obecnego miesiąca
    console.log(lastDayOfCurrentMonth);

    if ((dateChooseByUser >= firstDayOfCurrentMonth) && (dateChooseByUser <= lastDayOfCurrentMonth)) {
        console.log('YES');
        const elementDiv = document.getElementById('API');



        //elementDiv.append();


    } else {
        console.log('NO');
    }



}

/*
const getLimit = async () => {
    try {
        const response = await fetch('/Expense/showDataOfExpensesJSON');
        const data = response.json();
        console.log(data);
    }
    catch (e) {
        console.log('ERROR', e);
    }
};

getLimit();


const getLimit = async (categoryId) => {
    let reponse = await fetch(`/api/limit/${categoryId}`);
    console.log(response.data.categoryLimit);
}

getLimit();




fetch('/Expense/getLimit')
    .then((response) => response.json())
    .then((data) => console.log(data))





let categoryName = document.getElementById('exampleDataList');
let monthlyLimit = document.getElementById('monthlyLimit');
let alreadySpent = document.getElementById('alreadySpent');
let remainingAmount = document.getElementById('remaining');

const getLimit = async () => {
    let response = await fetch('/Expense/getLimit');
    const data = await response.json();

    for (let i = 0; i < data.length; i++) {
        if (categoryName.value == data[i].name) {
            monthlyLimit.textContent = `Monthly limit: ${data[i].sum}`;
            console.log(data[i].sum);
            // return data[i].sum;


        }
    }
}

let limitForCategory = getLimit();
console.log(limitForCategory);


const getSumOfExpensesForSelectedMonth = async () => {
    let response2 = await fetch('/Expense/getExpenses');
    const data2 = await response2.json();


    console.log(data2);
    for (let i = 0; i < data2.length; i++) {
        if (categoryName.value == data2[i].name) {
            alreadySpent.textContent = `Amount already spent on this category: ${data2[i].sum}`;
            console.log(data2[i].sum);
            // return data2[i].sum;

        }
    }
}

let sumOfExpenses = getSumOfExpensesForSelectedMonth();
console.log(sumOfExpenses);

/*

const getLimitForEachExpense = async () => {
    let response = await fetch('/Expense/getLimit');
    const data = await response.json();

    let categoryName = document.getElementById('exampleDataList');
    let monthlyLimit = document.getElementById('monthlyLimit');
    let alreadySpent = document.getElementById('alreadySpent');
    let remainingAmount = document.getElementById('remaining');


    for (let i = 0; i < data.length; i++) {
        if (categoryName.value == data[i].name) {
            monthlyLimit.textContent = `Monthly limit: ${data[i].sum}`;

            let response2 = await fetch('/Expense/getExpenses');
            const data2 = await response2.json();

            console.log(data2);
            for (let j = 0; i < data2.length; j++) {
                if (categoryName.value == data2[j].name) {
                    alreadySpent.textContent = `Amount already spent on this category: ${data2[j].sum}`;

                }
            }



        }
    }


}
*/

const difference = () => {
    let differenceLimit = limitForCategory - sumOfExpenses;
    console.log(differenceLimit);
}







function selectedPeriodOfTime() {
    let dateForm = document.getElementById('date').value;

    let date2 = new Date(dateForm);

    let currentMonth = date2.getMonth() + 1;
    let nextMonth = date2.getMonth() + 2;
    let currentYear = date2.getFullYear();


    let nextYear;
    if (currentMonth == 12) {
        nextMonth = '01';
        nextYear = currentYear + 1;
    }


    let currentMonthStart = new Date(currentYear + '-' + currentMonth + '-01');
    let currentMonthEnd = new Date(nextYear + '-' + nextMonth + '-01');

    console.log(currentMonthStart);
    console.log(currentMonthEnd);

}

const checkLimit = async () => {
    /*
    let limitForCategory = getLimit();
    console.log(limitForCategory);
    monthlyLimit.textContent = `Monthly limit: ${limitForCategory}`;
    let sumOfExpenses = getSumOfExpensesForSelectedMonth();
    console.log(sumOfExpenses);
    alreadySpent.textContent = `Amount already spent on this category: ${sumOfExpenses}`;
*/
    let dateForm = document.getElementById('date').value;

    let date2 = new Date(dateForm);

    let currentMonth = date2.getMonth() + 1;
    let nextMonth = date2.getMonth() + 2;
    let currentYear = date2.getFullYear();


    let nextYear;
    if (currentMonth == 12) {
        nextMonth = '01';
        nextYear = currentYear + 1;
    }


    let currentMonthStart = new Date(currentYear + '-' + currentMonth + '-01');
    let currentMonthEnd = new Date(nextYear + '-' + nextMonth + '-01');

    if (dateForm >= currentMonthStart && dateForm < currentMonthEnd) {
        getLimit();
        getSumOfExpensesForSelectedMonth();
        difference();
    }


}


let categoryName2 = document.querySelector('.categorySelect');

categoryName2.addEventListener('change', checkLimit);








const dateElement = document.querySelector('#date');
dateElement.addEventListener('change', selectedPeriodOfTime);

console.log(lastDayOfCurrentMonth);
console.log(firstDayOfCurrentMonth);
