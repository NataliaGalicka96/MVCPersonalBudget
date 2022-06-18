
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

*/


fetch('/Expense/getLimit')
    .then((response) => response.json())
    .then((data) => console.log(data))


const getLimitForEachExpense = async () => {
    let response = await fetch('/Expense/getLimit');
    const data = await response.json();

    let categoryName = document.getElementById('exampleDataList');
    let monthlyLimit = document.getElementById('monthlyLimit');


    for (let i = 0; i < data.length; i++) {
        if (categoryName.value == data[i].name) {
            console.log("to ta kategoria");
            monthlyLimit.textContent = `Monthly limit: ${data[i].sum}`;

        }
    }
}

getLimitForEachExpense();


let categoryName2 = document.querySelector('.categorySelect');
let monthlyLimit = document.getElementById('monthlyLimit');


categoryName2.addEventListener('change', getLimitForEachExpense);