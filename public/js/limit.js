

function showInputToSetLimit() {
    let checkbox = document.getElementById('defaultCheck1');
    let divLimit = document.getElementById('limit');

    if (checkbox.checked == true) {
        divLimit.style.visibility = 'visible';
    } else {
        divLimit.style.visibility = 'hidden';
    }

}


fetch('/Expense/showDataOfExpensesJSON')
    .then((response) => response.json())
    .then((data) => console.log(data));



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

