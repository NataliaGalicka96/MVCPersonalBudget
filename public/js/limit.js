
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

    } else {
        console.log('NO');
    }



}

